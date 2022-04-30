<?php
namespace App\Services\Implementations;

use App\Dtos\CountryQueryParam;
use App\Interfaces\CountryInterface;
use App\Models\Country;
use App\Services\ICountryService;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CountryService implements ICountryService{
    use ResponseAPI;

    protected CountryInterface $countryInterface;

    public function __construct(CountryInterface $countryInterface) {
        $this->countryInterface = $countryInterface;
    }

    public function getAllCountries(Request $request) {

        $queryParam = new CountryQueryParam;
        $queryParam->setParams($request);

        $result = $this->countryInterface->getAllCountries($queryParam);
        return $this->success("Results fetched", $result, 200);

    }
    public function saveOrUpdateCountry(Request $request, $id) {
        // validate request parameters
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required'
        ]);

        // check for validation error
        if( $validator->fails()) {
            return $this->error($validator->errors(), [], 422);
        }

        $country_name = $request->input('name');
        $country_code = $request->input('code');

        $exist = false;
        // check name exists
        if (!$id) {
            $exists = $this->countryInterface->checkCountryExists($country_name);
            if ($exists) {
                return $this->error("Country $country_name exists.", null, 400);
            }
        }

        // validate if country exists
        $country = $id ? $this->countryInterface->getCountryById($id) : new Country;
        $country->name = $request->input('name');
        $country->code = $request->input('code');

        DB::beginTransaction();
        try {

            $result = $this->countryInterface->createOrUpdateCountry($country);

            if ($result) {
                DB::commit();

                return $this->success($id ? "Country record updated" : "Country record created", $result, $id ? 200 : 201);
            }

            return $this->error('Could not save country, please try again later');

        } catch(\Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage(), null);
        }
    }
    public function getCountryById($id) {
        $result = $this->countryInterface->getCountryById($id);

        if ($result) {
            return $this->success("Country record found", $result, 200);
        }

        return $this->error("No such country record with id $id", null, 404);
    }


    public function deactivateCountry($id) {
        $country = Country::find($id);

        if (!$country) {
            return $this->error("No country with id: $id", 404);
        }
        DB::beginTransaction();
        try {
            $result = $this->countryInterface->deactivateCountry($country);

            if ( $result) {
                DB::commit();
                return $this->success("Country successfully deactivated", $result, 200);
            }
            return $this->error("Cannot deactivate country, please try again later", null, 400);
        }catch(\Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage(), null, 500);
        }

    }
}

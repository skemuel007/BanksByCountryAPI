<?php
namespace App\Repositories;

use App\Http\Requests\CountryRequest;
use App\Interfaces\CountryInterface;
use App\Traits\ResponseAPI;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryRepository implements CountryInterface {

    use ResponseAPI; // use trait

    public function getAllCountries($perPage = 30, $columns = ['*'], $pageName = 'countries', $page = 1) {
        try {
            $countries = Country::where('active', '=', true)->paginate(
                $perPage = $perPage,
                $columns = $columns,
                $pageName = $pageName,
                $page = $page
            );

            return $this->success('All countries', $countries);

        } catch(\Exception $ex) {
            return $this->error($ex->getMessage(), $ex->getCode());
        }
    }

    public function createOrUpdateCountry(CountryRequest $request, $id = null) {
        DB::beginTransaction();
        try {
            // if country exists then find it by id,
            // then update
            // else create the country
            $country = $id ? Country::find($id) : new Country;

            if ($id && !$country) {
                return $this->error("No country with ID: $id", 404);
            }

            $country->name = $request->name;
            $country->code = $request->code;
            $country->save();

            DB::commit();

        } catch(\Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage(), $ex->getCode());
        }
    }

    public function getCountryById($id) {
        try {
            $country = Country::find($id);

            // check the country
            if (!$country) {
                return $this->error("No country with this $id", 404);
            }
            return $this->success('Country record', $country);

        } catch(\Exception $ex) {
            return $this->error($ex->getMessage(), $ex->getCode());
        }
    }

    public function deactivateCountry($id) {
        DB::beginTransaction();
        try {
            // if country exists then find it by id,
            // then update
            // else create the country
            $country = Country::find($id);

            if (!$country) {
                return $this->error("No country with ID: $id", 404);
            }

            $country->active = false;
            $country->save();

            DB::commit();

        } catch(\Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage(), $ex->getCode());
        }
    }
}

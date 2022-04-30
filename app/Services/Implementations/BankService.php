<?php

namespace App\Services\Implementations;

use App\Dtos\BankQueryParam;
use App\Dtos\GetBanksByCountryQueryParam;
use App\Interfaces\BankInterface;
use App\Interfaces\CountryInterface;
use App\Models\Bank;
use App\Services\IBankService;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Output\ConsoleOutput;

class BankService implements IBankService
{
    use ResponseAPI;
    protected BankInterface $bankInterface;
    protected CountryInterface $countryInterface;

    public function __construct(BankInterface $bankInterface,
        CountryInterface $countryInterface)
    {
        $this->bankInterface = $bankInterface;
        $this->countryInterface = $countryInterface;
    }

    public function getAllBanks(Request $request) {

        $queryParam = new BankQueryParam;
        $queryParam->setParams($request);

        $result = $this->bankInterface->getAllBanks($queryParam);
        return $this->success("Results fetched", $result, 200);
    }

    public function saveOrUpdateBank(Request $request, $id = null) {
        // validate request parameters
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required'
        ]);

        // check for validation error
        if( $validator->fails()) {
            return $this->error($validator->errors(), [], 422);
        }

        $bank_name = $request->input('name');
        $country_id = $request->input('country_id');

        $exist = false;
        // check name exists
        if (!$id) {
            $exists = $this->bankInterface->checkBankExists($bank_name, $country_id);
            if ($exists) {
                return $this->error("Bank $bank_name alread created for country $country_id.", null, 400);
            }
        }

        // validate if country exists
        $bank = $id ? $this->bankInterface->getBankById($id) : new Bank;
        $bank->name = $request->input('name');
        $bank->swift_code = $request->input('swift_code');
        $bank->sort_code = $request->input('sort_code');
        $bank->country_id = $request->input('country_id');

        DB::beginTransaction();
        try {

            $result = $this->bankInterface->createOrUpdateBank($bank);

            DB::commit();

            return $this->success($id ? "Bank record updated" : "Bank record created", $result, $id ? 200 : 201);

        } catch(\Exception $ex) {
            DB::rollBack();
            return $this->error($ex->getMessage(), null);
        }

    }

    public function getBanksByCountry(Request $request) {

        $validator = Validator::make($request->query(), [
            'country_id' => 'required'
        ]);

        // check for validation error
        if( $validator->fails()) {
            return $this->error($validator->errors(), [], 422);
        }

        //$out = new ConsoleOutput();
        //$out->write($request->query('country_id'));

        $queryParam = new GetBanksByCountryQueryParam;
        $queryParam->setParams($request);

        // check if country exists
        $country = $this->countryInterface->getCountryById($queryParam->country_id);

        if (!$country) {
            return $this->error('Country with id ' . $queryParam->country_id . ' does not exist', null, 404);
        }

        $result = $this->bankInterface->getBanksByCountryId($queryParam);
        return $this->success('Banks fetched', $result, 200);
    }

    public function getBank($id) {
        $result = $this->bankInterface->getBankById($id);

        if ($result) {
            return $this->success("Bank record found", $result, 200);
        }

        return $this->error("No such bank record with id $id", null, 404);
    }

}

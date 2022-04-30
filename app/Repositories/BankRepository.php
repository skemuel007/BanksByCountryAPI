<?php

namespace App\Repositories;

use App\Dtos\BankQueryParam;
use App\Dtos\GetBanksByCountryQueryParam;
use App\Interfaces\BankInterface;
use App\Models\Bank;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;
use Validator;

class BankRepository implements BankInterface
{
    use ResponseAPI;
    protected $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function getAllBanks(BankQueryParam $queryParam) {

        $page = $queryParam->page;
        $perPage = $queryParam->page_size;
        $columns = $queryParam->columns;
        $pageName = $queryParam->page_name;

        $banks = Bank::where('active', '=', true);

        if (strtolower($queryParam->order_by) == 'desc') {
            $banks = $banks->orderBy('id', 'DESC');
        } else {
            $banks = $banks->orderBy('id', 'ASC');
            $this->output->writeln(json_encode($banks->paginate()));
        }

        if($queryParam->search) {
            $banks = $banks->OrWhere('name', 'LIKE', "'%$queryParam->search%'")
                    ->orWhere('code', 'LIKE', "'%$queryParam->search%'");
        }

        $banks = $banks->with('country')->paginate(
            $perPage = $perPage,
            $columns = $columns,
            $pageName = $pageName,
            $page = $page
        );
        // $this->output->writeln(json_encode($countries));

        return $banks;
    }

    public function checkBankExists($bankName, $country_id) {
        $column = 'name';
        $result = Bank::whereRaw("name LIKE '%$bankName%'")->
                    where('country_id', '=', $country_id)->first();
        return $result ? true : false;
    }

    public function createOrUpdateBank(Bank $bank) {
        return $bank->save();
    }

    public function getBankById($id) {
        $bank = Bank::findOrFail($id)->with('country')->first();
        return $bank;
    }

    public function deactivateBank(Bank $bank) {
        DB::beginTransaction();
        try{
            $bank->save();

            DB::commit();

            return [true, $bank];

        } catch(\Exception $ex) {
            DB::rollBack();
            return [false, $ex->getMessage()];
        }
    }

    public function getBanksByCountryId(GetBanksByCountryQueryParam $queryParam){

        $page = $queryParam->page;
        $perPage = $queryParam->page_size;
        $columns = $queryParam->columns;
        $pageName = $queryParam->page_name;

        $this->output->write($queryParam->country_id);

        $banks = Bank::where('active', '=', true)->where('country_id', '=', $queryParam->country_id);
        if (strtolower($queryParam->order_by) == 'desc') {
            $banks = $banks->orderBy('id', 'DESC');
        } else {
            $banks = $banks->orderBy('id', 'ASC');
            $this->output->writeln(json_encode($banks->paginate()));
        }

        if($queryParam->search) {
            $banks = $banks->OrWhere('name', 'LIKE', "'%$queryParam->search%'")
                    ->orWhere('code', 'LIKE', "'%$queryParam->search%'");
        }

        $banks = $banks->with('country')->paginate(
            $perPage = $perPage,
            $columns = $columns,
            $pageName = $pageName,
            $page = $page
        );
        // $this->output->writeln(json_encode($countries));

        return $banks;
    }
    public function deleteBank(Bank $bank) {
        DB::beginTransaction();
        try {

            $bank->delete();

            DB::commit();

            return [true, null];

        } catch(\Exception $ex) {
            DB::rollBack();
            return [false, $ex->getMessage()];
        }
    }
}

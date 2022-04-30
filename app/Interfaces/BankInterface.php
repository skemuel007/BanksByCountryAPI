<?php

namespace App\Interfaces;

use App\Dtos\BankQueryParam;
use App\Dtos\GetBanksByCountryQueryParam;
use App\Models\Bank;

interface BankInterface {
    public function getAllBanks(BankQueryParam $queryParam);
    public function createOrUpdateBank(Bank $bank);
    public function getBankById($id);
    public function getBanksByCountryId(GetBanksByCountryQueryParam $queryParam);
    public function deactivateBank(Bank $bank);
    public function deleteBank(Bank $bank);
    public function checkBankExists($bankName, $country_id);
}

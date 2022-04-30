<?php

namespace App\Services;

use Illuminate\Http\Request;

interface IBankService {
    public function getAllBanks(Request $request);
    public function saveOrUpdateBank(Request $request, $id = null);
    public function getBank($id);
    public function getBanksByCountry(Request $request);
}

<?php
namespace App\Services;

use Illuminate\Http\Request;

interface ICountryService {

    public function getAllCountries(Request $request);
    public function saveOrUpdateCountry(Request $request, $id);
    public function getCountryById($id);
    public function deactivateCountry($id);
}

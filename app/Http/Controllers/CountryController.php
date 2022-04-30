<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ICountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected ICountryService $countryService;

    public function __construct(ICountryService $countryService) {
        $this->countryService = $countryService;
    }

    /**
     * Display a paginated listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        return $this->countryService->getAllCountries($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return $this->countryService->saveOrUpdateCountry($request, null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Respons
     */
    public function show($id) {
        return $this->countryService->getCountryById($id);
    }

    /**
     * Updates the specified resource in db
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        return $this->countryService->saveOrUpdateCountry($request, $id);
    }

    /**
     * Deactivates a country
     *
     * @param int $id
     * return \Illuminate\Http\Response
     */
    public function deactivate($id) {
        return $this->countryService->deactivateCountry($id);
    }
}

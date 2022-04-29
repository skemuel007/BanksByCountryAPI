<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Interfaces\CountryInterface;

class CountryController extends Controller
{
    protected CountryInterface $countryInterface;

    public function __construct(CountryInterface $countryInterface) {
        $this->countryInterface = $countryInterface;
    }

    /**
     * Display a paginated listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($perPage = 30, $columns = ['*'], $pageName = 'countries', $page = 1) {
        return $this->countryInterface->getAllCountries($perPage, $columns, $pageName, $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request) {
        return $this->countryInterface->createOrUpdateCountry($request, null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Respons
     */
    public function show($id) {
        return $this->countryInterface->getCountryById($id);
    }

    /**
     * Updates the specified resource in db
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id) {
        return $this->countryInterface->createOrUpdateCountry($request, $id);
    }

    /**
     * Deactivates a country
     *
     * @param int $id
     * return \Illuminate\Http\Response
     */
    public function destroy($id) {
        return $this->countryInterface->deactivateCountry($id);
    }
}

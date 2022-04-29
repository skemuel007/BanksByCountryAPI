<?php
namespace App\Interfaces;

use App\Http\Requests\CountryRequest;

interface CountryInterface
{
    /**
     * Get all countries
     *
     * @method GET api/v1/countries
     */
    public function getAllCountries($perPage = 30, $columns = ['*'], $pageName = 'countries', $page = 1);

    /**
     * Create | Update countries
     *
     * @param \App\Http\Requests\CountryRequest $request
     * @param integer $id
     */
    public function createOrUpdateCountry(CountryRequest $request, $id = null);

    /**
     * Get Country By Id
     *
     * @param integer $id
     *
     * @method GET api/country/{id}
     * @access public
     */
    public function getCountryById($id);

    /**
     * Get Country By Id
     *
     * @param integer $id
     *
     * @method PUT api/country/{id}
     * @access public
     */
    public function deactivateCountry($id);
}

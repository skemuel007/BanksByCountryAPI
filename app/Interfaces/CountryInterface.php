<?php
namespace App\Interfaces;

use App\Dtos\CountryQueryParam;
use App\Models\Country;

interface CountryInterface
{
    /**
     * Get all countries
     *
     * @method GET api/v1/countries
     */
    public function getAllCountries(CountryQueryParam $queryParam);

    /**
     * Create | Update countries
     *
     * @param \App\Http\Requests\CountryRequest $request
     * @param integer $id
     */
    public function createOrUpdateCountry(Country $country);
    public function checkCountryExists($country_name);

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
     * @method Delete api/country/{id}
     * @access public
     */
    public function deactivateCountry(Country $country);
}

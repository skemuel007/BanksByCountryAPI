<?php

namespace App\Dtos;

use Illuminate\Http\Request;

class GetBanksByCountryQueryParam extends QueryParam{

    public $country_id;
    public function __construct($page = 1, $page_size = 30, $search = '', $order_by = '') {

    }

    // override set params of the parent class
    public function setParams(Request $request) {
        parent::setParams($request);
        $this->country_id = (int)$request->input('country_id');
    }
}

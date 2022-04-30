<?php

namespace App\Dtos;

class CountryQueryParam extends QueryParam
{
    public function __construct($page = 1, $page_size = 30, $search = '', $order_by = 'ASC')
    {
        $this->page = $page;
        $this->page_size = $page_size;
        $this->search = $search;
        $this->order_by = $order_by;
    }
}

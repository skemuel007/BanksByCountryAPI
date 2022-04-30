<?php

namespace App\Dtos;

use Illuminate\Http\Request;

class QueryParam {
    public $page = 1;
    public $page_size = 30;
    public $order_by = 'ASC';
    public $search;
    public $columns = ['*'];
    public $page_name = 'page';

    public function setParams(Request $request) {
        $this->page = $request->has('page') ? (int)$request->query('page') : $this->page;
        $this->search = $request->has('search') ? $request->query('search') : $this->search;
        $this->order_by = $request->has('order_by') ? $request->query('order_by') : $this->order_by;
        $this->page_size = $request->has('page_size')
                        ? (((int)$request->query('page_size') < 0 || (int)$request->query('page_size') > 30) ? 30 : (int)$request->query('page_size'))
                        : $this->page_size;
    }
}

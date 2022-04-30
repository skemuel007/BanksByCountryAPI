<?php

namespace App\Http\Controllers;

use App\Services\IBankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    protected IBankService $bankService;

    public function __construct(IBankService $bankService) {
        $this->bankService = $bankService;
    }
    /**
     * Display a paginated listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        return $this->bankService->getAllBanks($request);
    }

    public function banksByCountry(Request $request) {
        return $this->bankService->getBanksByCountry($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return $this->bankService->saveOrUpdateBank($request, null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->bankService->getBank($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->bankService->saveOrUpdateBank($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deactivateBank($id)
    {
        return $this->bankInterface->deactivateBank($id);
    }
}

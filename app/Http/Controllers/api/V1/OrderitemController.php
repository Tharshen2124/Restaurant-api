<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Requests\StoreOrderitemRequest;
use App\Http\Requests\UpdateOrderitemRequest;
use App\Http\Controllers\Controller;
use App\Models\Orderitem;

class OrderitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderitemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Orderitem $orderitem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderitemRequest $request, Orderitem $orderitem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderitem $orderitem)
    {
        //
    }
}

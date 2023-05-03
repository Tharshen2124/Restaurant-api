<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateOrderRequest;
use App\Http\Requests\V1\StoreOrderRequest as Enter;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Enter $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

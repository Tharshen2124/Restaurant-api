<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Orderitem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\V1\StoreOrderitemRequest;
use App\Http\Requests\V1\UpdateOrderitemRequest;

class OrderitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderitemRequest $request, Menu $menu)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Orderitem $orderitem)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderitemRequest $request, Orderitem $orderitem)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderitem $orderitem)
    {
        
    }
}

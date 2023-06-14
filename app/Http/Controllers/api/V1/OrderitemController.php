<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Orderitem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\V1\StoreOrderitemRequest;
use App\Http\Requests\V1\StoreOrderRequest;
use App\Http\Requests\V1\UpdateOrderitemRequest;
use App\Http\Resources\V1\OrderitemResource;

class OrderitemController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        
    }
    
    // (need to make it hidden) name="menuitem_id" value="{{ $menu->id }}" -> this how it will look like in blade
    
    // Store a newly created resource in storage.
    public function store(StoreOrderitemRequest $request,Menu $menu)
    {   
        $request->validated($request->all());
        
        // /https://laravel.com/docs/10.x/eloquent#retrieving-or-creating-models
        // use firstorcreate to create order if (status = pending & order with user id doesnt exist)
        $order = Order::firstorcreate(
            [
                "status" => "pending",
                "user_id" => Auth::id(), //same as Auth::user()->id
            ],
            [ "payment" => 0 ]
        );

        $orderitem = Orderitem::create([
            'order_id' => $order->id,
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity
        ]);

        if($orderitem->save()) {
            return [
                'message' => 'Success!',
                'orderitem' => new OrderitemResource($orderitem)
            ];
        } else {
            return [
                'message' => 'Hhhhmm, something went wrong...',
            ];
        }
    }

    //Display the specified resource.
    public function show(Orderitem $orderitem)
    {
        
    }

    // Update the specified resource in storage.
    public function update(UpdateOrderitemRequest $request)
    {        
        
    }

    // Remove the specified resource from storage.
    public function destroy(Orderitem $orderitem)
    {
        
    }
}

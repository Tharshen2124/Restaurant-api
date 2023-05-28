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
    public function store(Request $request,Menu $menu)
    {   

        /*  dd($menu->id); */
        /* $menu = Menu::find($id); */
        /* $request->validate($request->all()); */
       
        // /https://laravel.com/docs/10.x/eloquent#retrieving-or-creating-models
        // use firstorcreate to create order if (status = pending & order with user id doesnt exist)
        $order = Order::firstorcreate(
            [
                "status" => "pending",
                "user_id" => Auth::id(), //same as Auth::user()->id
            ],
            [ "payment" => 0 ]
        );

        $orderitem = new Orderitem;
        $orderitem->order_id = $order->id;
        $orderitem->menu_id = $menu->id;
        $orderitem->quantity = $request->quantity;

        if($orderitem->save()) {
            return [
                'message' => 'Success!',
                /* 'orderitem' => $orderitem */
            ];
        } else {
            return [
                'message' => 'fuck'
            ];
        }
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

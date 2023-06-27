<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\V1\OrderResource;
use App\Http\Requests\V1\UpdateOrderRequest;
use App\Http\Requests\V1\StoreOrderRequest as Enter;

class OrderController extends Controller
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
    public function store(Request $request)
    {
        Cache::forget('numOfItems');
        $order = Order::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->with('orderitems.menu')
                    ->firstorfail();
        $payment = 0;

        foreach ($order->orderitems as $orderitem) 
        {
            $payment += ($orderitem->menu->price * $orderitem->quantity);
        }

        $order->payment = $payment;
        $order->status = "completed";
        
        if($order->save()) {
            return [
                'message' => 'Success!',
                'order' => new OrderResource($order),
            ];
        } else {
            return [
                'message' => 'something went wrong',
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $payment = 0;
        $order = Auth::user()
                    ->orders()
                    ->where('status', 'pending')
                    ->with('orderitems.menu')
                    ->first();
        
        foreach ($order->orderitems as $orderitem) {
            $payment += ($orderitem->menu->price * $orderitem->quantity);
        }
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

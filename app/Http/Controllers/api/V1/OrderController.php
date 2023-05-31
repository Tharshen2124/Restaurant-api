<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
    public function store(Request $request, Orderitem $orderitem)
    {
        // get the existing order and make it complete
        // eager loading https://laravel.com/docs/10.x/eloquent-relationships#eager-loading
        $order = Order::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->with('orderitems.menu') //eager loading
                    ->firstorfail();
        $payment = 0;
        foreach ($order->orderitems as $orderitem) {
            $payment += ($orderitem->menu->price * $orderitem->quantity);
        }
        $order->payment = $payment;
        $order->status = "completed";
        
        if($order->save()) {
            return [
                'message' => 'Success!',
                'order' => $order,
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

        return view('pages.confirm-order-page', [
            'orderitems' => $order->orderitems,
            'payment' => $payment
        ]);
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

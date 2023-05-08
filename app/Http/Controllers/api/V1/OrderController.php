<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Order;
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
    public function store(Enter $request)
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
        $order->save();
        
        return view('pages.ordered-page', [
            'orderitems' => $order->orderitems,
            'order' => $order,
            'payment' => $payment,
        ]);
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

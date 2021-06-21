<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderDestroyRequest;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Requests\Order\OrderShowRequest;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderIndexRequest $request)
    {
        $authenticatedUserRole = Auth::user()->role;

        if ($authenticatedUserRole === 'ADMINISTRATOR') {
            $orders = Order::with('customer')->get();
        }

        if ($authenticatedUserRole === 'CUSTOMER') {
            $authenticatedCustomer = Auth::user()->profile;
            $orders = $authenticatedCustomer->orders;
        }

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        // ReValidate Items

        $authenticatedCustomer = Auth::user()->profile;

        $orderData = [
            'customer_id' => $authenticatedCustomer->id,
            'address' => $request->validated()['address'],
            'latitude' => $request->validated()['latitude'],
            'longitude' => $request->validated()['longitude'],
            'distance' => $request->validated()['distance'],
            'sub_total' => 99999,
            'delivery_fee' => 99999,
            'grand_total' => 99999,
            'status' => 'PENDING'
        ];

        $order = Order::create($orderData);

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(OrderShowRequest $request, Order $order)
    {
        $order->load('customer');
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDestroyRequest $request, Order $order)
    {
        //
    }
}

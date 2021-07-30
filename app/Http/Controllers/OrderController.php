<?php

namespace App\Http\Controllers;

use App\DeliveryFee;
use App\Http\Requests\Order\OrderDestroyRequest;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Requests\Order\OrderShowRequest;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderProduct;
use App\Product;
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
            $orders = Order::with('customer', 'orderProducts', 'orderProducts.product')->orderBy('id', 'desc')->get();
        }

        if ($authenticatedUserRole === 'CUSTOMER') {
            $authenticatedCustomer = Auth::user()->profile;
            $orders = $authenticatedCustomer->orders->load('orderProducts', 'orderProducts.product');
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
            'delivery_fee' => null,
            'grand_total' => 99999,
            'status' => 'PENDING'
        ];

        // Delivery Fee
        $distance = $orderData['distance'];
        $deliveryFee = DeliveryFee::where('from', '<=', $distance)->where('to', '>=', $distance)->first();
        $fee = $deliveryFee ? $deliveryFee->fee : null;

        if ($fee)
            $orderData['delivery_fee'] = $fee;
        else
            return response(['message' => 'Location Out Of Reach.'], 422);

        // Order Products
        $subTotal = 0; $orderProductsInfo = [];
        $orderProducts = $request->validated()['products'];
        foreach($orderProducts as $orderProduct) {
            $product = Product::findOrFail($orderProduct['id']);

            $orderProductsInfo[] = [
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $orderProduct['quantity'],
                'total' => (double) $product->price * $orderProduct['quantity'],
            ];

            $subTotal += (double) $product->price * $orderProduct['quantity'];
        }

        // Sub Total
        $orderData['sub_total'] = $subTotal;

        // Grand Total
        $orderData['grand_total'] = $orderData['sub_total'] + $orderData['delivery_fee'];

        // Create Order
        $order = Order::create($orderData);

        // Create Order Products
        foreach($orderProductsInfo as $orderProduct) {
            OrderProduct::create(array_merge($orderProduct, ['order_id' => $order->id]));
        }

        $order->load('orderProducts', 'orderProducts.product');

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
        $order->load('customer', 'orderProducts', 'orderProducts.product');
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
        $order->load('customer', 'orderProducts', 'orderProducts.product');

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

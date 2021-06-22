<?php

namespace App\Http\Controllers;

use App\DeliveryFee;
use App\Http\Requests\DeliveryFee\DeliveryFeeDestroyRequest;
use App\Http\Requests\DeliveryFee\DeliveryFeeIndexRequest;
use App\Http\Requests\DeliveryFee\DeliveryFeeShowRequest;
use App\Http\Requests\DeliveryFee\DeliveryFeeStoreRequest;
use App\Http\Requests\DeliveryFee\DeliveryFeeUpdateRequest;
use App\Http\Resources\DeliveryFeeResource;
use Illuminate\Http\Request;

class DeliveryFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DeliveryFeeIndexRequest $request)
    {
        $deliveryFees = DeliveryFee::all();

        return DeliveryFeeResource::collection($deliveryFees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryFeeStoreRequest $request)
    {
        $deliveryFee = DeliveryFee::create($request->validated());

        return new DeliveryFeeResource($deliveryFee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeliveryFee  $deliveryFee
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryFeeShowRequest $request, DeliveryFee $deliveryFee)
    {
        return new DeliveryFeeResource($deliveryFee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryFee  $deliveryFee
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryFeeUpdateRequest $request, DeliveryFee $deliveryFee)
    {
        $deliveryFee->update($request->validated());

        return new DeliveryFeeResource($deliveryFee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeliveryFee  $deliveryFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryFeeDestroyRequest $request, DeliveryFee $deliveryFee)
    {
        $deliveryFee->delete();

        return response(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Customer\CustomerDestroyRequest;
use App\Http\Requests\Customer\CustomerIndexRequest;
use App\Http\Requests\Customer\CustomerShowRequest;
use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerIndexRequest $request)
    {
        $customers = Customer::with('user')->get();

        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $customerUserData = array_merge(
                Arr::only($request->validated(), ['email', 'password']),
                ['role' => 'CUSTOMER']
            );
            $customerUser = User::create($customerUserData);

            $customerData = array_merge(
                Arr::only($request->validated(), [
                    'first_name', 'last_name', 'contact_number',
                    'address', 'latitude', 'longitude'
                ]), ['user_id' => $customerUser->id]
            );
            $customer = Customer::create($customerData);

            DB::commit();

            $customer->load('user');
            return new CustomerResource($customer);
        } catch (Throwable $th) {
            DB::rollBack();
            return response(['message' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerShowRequest $request, Customer $customer)
    {
        $customer->load('user');
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        try {
            DB::beginTransaction();

            $customer->user->update($request->validated());
            $customer->update($request->validated());

            DB::commit();

            $customer->load('user');
            return new CustomerResource($customer);
        } catch (Throwable $th) {
            DB::rollBack();
            return response(['message' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerDestroyRequest $request, Customer $customer)
    {
        $customer->delete();

        return response(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\CustomerResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request)
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
                ]),
                ['user_id' => $customerUser->id]
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
}

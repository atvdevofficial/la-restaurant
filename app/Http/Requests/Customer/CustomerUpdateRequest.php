<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authenticatedUserRole = Auth::user()->role;

        if ($authenticatedUserRole === 'ADMINISTRATOR')
            return TRUE;

        if ($authenticatedUserRole === 'CUSTOMER') {
            $authenticatedCustomer = Auth::user()->profile;
            $routeCustomer = $this->route('customer');

            if ($authenticatedCustomer->id === $routeCustomer->id)
                return TRUE;
        }

        return FALSE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $routeCustomer = $this->route('customer');
        $customerUser = $routeCustomer->user;

        return [
            // User Model
            'email' => ['required', 'email' , 'unique:users,email,' . $customerUser->id], // Except current user
            'password' => ['nullable', 'string' , 'min:8'],

            // Customer Model
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'contact_number' => ['required', 'string'],
            'address' => ['required', 'string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }
}

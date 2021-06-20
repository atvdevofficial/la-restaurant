<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerStoreRequest extends FormRequest
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

        return FALSE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // User Model
            'email' => ['required', 'email' , 'unique:users,email'],
            'password' => ['required', 'string' , 'min:8'],

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

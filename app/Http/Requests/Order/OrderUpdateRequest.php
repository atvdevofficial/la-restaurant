<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderUpdateRequest extends FormRequest
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
            $routeOrder = $this->route('order');

            if ((int) $authenticatedCustomer->id === (int) $routeOrder->customer_id)
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
        $authenticatedUserRole = Auth::user()->role;

        if ($authenticatedUserRole === 'ADMINISTRATOR') {
            return [
                'status' => ['required', 'in:CANCELLED,DECLINED,PENDING,PROCESSING,ON-THE-WAY,DELIVERED']
            ];
        }

        if ($authenticatedUserRole === 'CUSTOMER') {
            return [
                'status' => ['required', 'in:CANCELLED,DELIVERED']
            ];
        }
    }
}

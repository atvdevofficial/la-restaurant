<?php

namespace App\Http\Requests\DeliveryFee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeliveryFeeUpdateRequest extends FormRequest
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
        $deliveryFee = $this->route('deliveryFee');

        return [
            'from' => ['required', 'numeric', 'unique:delivery_fees,from,' . $deliveryFee->id],
            'to' => ['required', 'numeric', 'unique:delivery_fees,to,' . $deliveryFee->id],
            'fee' => ['required', 'numeric'],
        ];
    }
}

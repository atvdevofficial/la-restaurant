<?php

namespace App\Http\Requests\DeliveryFee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeliveryFeeCalculateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authenticatedUserRole = Auth::user()->role;

        if ($authenticatedUserRole === 'CUSTOMER')
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
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }
}

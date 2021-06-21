<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_link' => ['required'],

            'product_categories' => ['required', 'array', 'min:1'],
            'product_categories.*' => ['required', 'exists:product_categories,id']
        ];
    }
}

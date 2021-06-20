<?php

namespace App\Http\Requests\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductCategoryStoreRequest extends FormRequest
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
            'name' => ['required', 'unique:product_categories,name']
        ];
    }
}

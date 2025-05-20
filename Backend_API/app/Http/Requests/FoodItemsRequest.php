<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'recipeID' => 'nullable|integer|exists:recipes,id',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:100',
        'stockQuantity' => 'required|integer|min:0',
        'ImageURL' => 'required|string|max:5000',
    ];
}

}

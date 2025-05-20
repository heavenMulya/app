<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
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
        'orderItems' => 'required|array', // Ensure the request contains an array of order items
        'orderItems.*.orderID' => 'required|integer',
        'orderItems.*.foodItemID' => 'required|integer',
        'orderItems.*.quantity' => 'required|integer|min:1',
        'orderItems.*.status' => 'required|string|in:New,In Progress,Completed,On Hold',
    ];
}


}

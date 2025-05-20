<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        'customerName' => 'nullable|string|max:255',
        'CustomerPhone' => 'nullable|string|max:255',
        'TableName' => 'required|int|max:255',
        'orderStatus' => 'required|string|in:New,In Progress,Completed,On Hold',
    ];
}

}

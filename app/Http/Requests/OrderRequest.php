<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

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
    public function rules(): array
    {
        return [
            'products' => 'required|array',
            'products.*.good_id' => 'required',
            'products.*.count' => 'required',
            'products.*.price' => 'required',
            'products.*.sale' => '',
            'email' => 'required|email',
            'product_sum' => 'required',
            'delivery' => '',
            'delivery_sum' => '',
            'total_summa' => '',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
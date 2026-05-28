<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method'  => 'required|in:cod,bank_transfer',
            'shipping_address' => 'nullable|required_without:use_existing_address|string|max:1000',
            'order_notes'     => 'nullable|string|max:2000',
            'use_existing_address' => 'nullable|exists:user_addresses,address_id',
        ];
    }
}

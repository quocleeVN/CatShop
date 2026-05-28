<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // đã protect bằng middleware admin
    }

    public function rules(): array
    {
        return [
            'breed_id'       => 'required|exists:cat_breeds,breed_id',
            'name'           => 'required|string|max:100',
            'price'          => 'required|numeric|min:0',
            'age_in_months'  => 'required|integer|min:0|max:240',
            'gender'         => 'required|in:male,female',
            'color'          => 'nullable|string|max:50',
            'weight'         => 'nullable|numeric|min:0|max:30',
            'description'    => 'nullable|string|max:2000',
            'health_status'  => 'nullable|string|max:100',
            'is_vaccinated'  => 'boolean',
            'stock_status'   => 'required|in:available,sold,reserved',
            'link_image'     => 'nullable|url|max:500',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:190',
            'email' => 'nullable|email:rfc,dns',
            'phone' => 'nullable|regex:/^[0-9\s+]+$/',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (empty($this->input('email')) && empty($this->input('phone'))) {
                $validator->errors()->add('email', 'At least one of email or phone is required.');
                $validator->errors()->add('phone', 'At least one of email or phone is required.');
            }
        });
    }
}

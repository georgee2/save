<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) ($this->user() && $this->user()->isCustomer());
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            // regex restricts to printable ASCII (no Arabic / non-Latin characters).
            'password' => ['required', 'string', 'confirmed', 'regex:/^[\x20-\x7E]+$/', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => __('lang.account_password_english_only'),
        ];
    }
}

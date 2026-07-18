<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreferencesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) ($this->user() && $this->user()->isCustomer());
    }

    public function rules(): array
    {
        return [
            'preferred_locale' => ['required', Rule::in(['en', 'ar'])],
            'notify_email_updates' => ['nullable', 'boolean'],
            'notify_project_updates' => ['nullable', 'boolean'],
        ];
    }
}

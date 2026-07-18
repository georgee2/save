<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) ($this->user() && $this->user()->isCustomer());
    }

    public function rules(): array
    {
        $id = $this->user()->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($id),
                // Do not allow taking an address another user is mid-verifying.
                Rule::unique('users', 'pending_email')->ignore($id),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge(['email' => \Illuminate\Support\Str::lower(trim($this->email))]);
        }
    }
}

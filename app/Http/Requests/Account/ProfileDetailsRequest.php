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

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($id),
                // Do not allow taking an address another user is mid-verifying.
                Rule::unique('users', 'pending_email')->ignore($id),
            ],
        ];

        // Redirecting the account's email is the first move in taking it over, so it needs
        // proof of the password rather than just a live session. Only demanded when the
        // address is actually changing, so editing a name or phone stays frictionless.
        if ($this->emailIsChanging()) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        return $rules;
    }

    public function emailIsChanging(): bool
    {
        return $this->input('email') !== null
            && $this->input('email') !== $this->user()->email;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge(['email' => \Illuminate\Support\Str::lower(trim($this->email))]);
        }
    }
}

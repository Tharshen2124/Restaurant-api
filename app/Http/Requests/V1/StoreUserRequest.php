<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        /* ,'unique:App\Models\User,email' */
        return [
            'name' => ['required', 'max:255', 'min:3'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', Password::defaults()],
        ];
    }
}

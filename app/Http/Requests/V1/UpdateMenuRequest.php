<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
        $method = $this->method();

        if($method == 'PUT') {
            return [
                'menu_item' => ['required'],
                'type' => ['required', Rule::in(['food', 'drink'])],
                'price' => ['required'],
            ];
        } else {
            return [
                'menu_item' => ['sometimes', 'required'],
                'type' => ['sometimes', 'required', Rule::in(['food', 'drink'])],
                'price' => ['sometimes', 'required'],
            ]; 
        }
    }   
}

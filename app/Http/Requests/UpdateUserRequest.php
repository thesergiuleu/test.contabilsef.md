<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'company' => ['required', 'string'],
            'position' => ['required', 'string'],
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, $this->user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];
    }
}

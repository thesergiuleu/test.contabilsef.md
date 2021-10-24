<?php

namespace App\Http\Requests;

use App\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInstruireRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cod_fiscal' => 'nullable',
            'company_name' => 'nullable',
            'payment_method' => ['nullable', Rule::in(array_flip(Post::PAYMENT_METHODS))],
            'message' => 'nullable',
            'ip_address' => 'nullable',
            'terms' => 'required|accepted',
            'subscribe' => 'nullable'
        ];
    }
}

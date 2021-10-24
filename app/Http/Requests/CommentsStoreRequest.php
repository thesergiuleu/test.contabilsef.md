<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentsStoreRequest extends FormRequest
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
        $required = auth()->user() ? 'nullable' : 'required';
        return [
            'name' => 'nullable',
            'email' => 'nullable|email',
            'body' => 'required',
            'parent_id' => 'nullable',
        ];
    }
}

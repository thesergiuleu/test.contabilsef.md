<?php

namespace App\Http\Requests;

use App\Subscription;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubscriptionRequest extends FormRequest
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
            'service_id' => ['required', 'exists:subscription_services,id'],
            'cod_fiscal' => 'nullable',
            'payment_method' => ['nullable'],
            'message' => 'nullable',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'company' => 'nullable',
            'terms' => 'required',
            'price' => 'required'
        ];
    }
}

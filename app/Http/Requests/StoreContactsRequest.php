<?php

namespace App\Http\Requests;

use App\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactsRequest extends FormRequest
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
            'phone' => $this->request->get('page') == Contact::PAGE_CONTACT ? 'required' : 'nullable',
            'message' => 'nullable',
            'ip_address' => 'nullable',
            'g-recaptcha-response' => auth()->user() ? 'nullable' : 'required|recaptcha',
            'page' => ['required', Rule::in(Contact::PAGES)],
        ];
    }
}

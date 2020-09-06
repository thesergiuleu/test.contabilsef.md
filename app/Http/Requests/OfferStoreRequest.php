<?php

namespace App\Http\Requests;

use App\Offer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfferStoreRequest extends FormRequest
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
            'company_name' => 'required|string',
            'vacancy' => [
                'required',
                Rule::in(Offer::VACANCIES)
            ],
            'location' => [
                'required',
                Rule::in(Offer::LOCATIONS)
            ],
            'salary' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'required|email',
            'studies' => [
                'nullable',
                Rule::in(Offer::STUDIES)
            ],
            'time_shift' => [
                'nullable',
                Rule::in(Offer::TIME_SHIFTS)
            ],
            'logo' => 'nullable|file',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'website' => 'nullable|string',
            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }
}

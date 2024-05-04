<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateAuth extends FormRequest
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
            'first_name'  => 'alpha|min:2',
            'last_name'   => 'alpha',
            'middle_name' => 'alpha',
            'zipcode'     => 'digits:5',
            'phone'       => 'digits',
            'alt_phone'   => 'digits',
            'email'       => 'email',
            'alt_email'   => 'email'
        ];
    }
}

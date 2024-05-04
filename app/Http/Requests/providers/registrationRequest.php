<?php

namespace App\Http\Requests\providers;

use Illuminate\Foundation\Http\FormRequest;

class registrationRequest extends FormRequest
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
            'company_name'     => 'required|unique:practises,name',
            'phone'            => 'required|unique:practises,phone',
            'address'          => 'required',
            'state'            => 'required',
            'city'             => 'required',
            'zipcode'          => 'required|string|size:5',
            'name'             => 'required',
            'email'            => 'required|email|unique:providers,email,unique:practises,email',
            'password'         => 'required|between:8,25',
            'confirm_password' =>  [
                'required',
                'between:8,25',
                function($attr, $value, $fail) {
                    if($value != request()->password) {
                        $fail("Passwords do not match");
                    }
                }
            ],
            'npi'              => 'nullable|numeric|min:10,max:10'
        ];
    }
}

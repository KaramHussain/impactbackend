<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Events\Auth\userRequestedActivationEmail;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function register(Request $request)
    {

        $validator = $this->validateUser($request);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()], 422);
        }

        $dob = $this->dateFormat([$request->day, $request->month, $request->year]);

        $user = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'gender'            => $request->gender,
            'dob'               => $dob,
            'activation_token'  => Str::random(255),
            'has_insurance'     => $request->insurance
        ]);

        $this->addAddress($user, $request);

        event(new userRequestedActivationEmail($user));
        return response()->json(['Please activate your account'], 201);

    }

    public function dateFormat($date)
    {
        $year  = $date[2];
        $month = $date[1];
        $day   = $date[0];
        $date  = date('Y-m-d', strtotime($year.'-'.$month.'-'.$day));
        return $date;
    }

    public function validateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'       =>  'required',
            'last_name'        =>  'required',
            'address'          =>  'required',
            'email'            =>  'email|required|unique:users',
            'password'         =>  'required|between:8,25',
            'confirm_password' =>  [
                'required',
                'between:8,25',
                function($attr, $value, $fail) use($request) {
                    if($value != $request->password) {
                        $fail("Passwords do not match");
                    }
                }
            ],
            'day'    => Rule::notIn(0),
            'month'  => Rule::notIn(0),
            'year'   => Rule::notIn(0),
            'gender' => Rule::notIn(0),
        ]);
        return $validator;
    }

    public function addAddress(User $user, $request)
    {
        $user->address()->create([
            $request->address
        ]);
    }
}

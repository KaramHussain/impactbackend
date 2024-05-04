<?php

namespace App\Http\Controllers\auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\updateAuth;
use App\Http\Resources\UserResource;

class meController extends Controller
{

    public function me(Request $request)
    {
        // dd($request()->user());
        return new UserResource($request->user());
    }

    public function update(Request $request)
    {

        $auth_id = optional($request->user())->id;

        if(!$auth_id)
        {
            return response()->json(['Action not allowed!']);
        }

        $profile = $request->data['profile'];

        $mandatory = ['first_name', 'email', 'gender', 'phone', 'dob', 'state', 'city', 'address', 'zipcode'];
        $errors = [];

        foreach($profile as $key => $value)
        {
            $param = ucfirst(str_replace('_', ' ', $key));
            if(empty($value) && in_array($key, $mandatory))
            {
                $errors[$key] = ["{$param} is required"];
            }
            if(($key == 'gender' || $key == 'state' || $key == 'city')&& $value == 0)
            {
                $errors[$key] = ["{$param} is required"];
            }
        }

        if(!empty($errors))
        {
            return response()->json(['status' => 429, 'errors' => $errors]);
        }

        $user = new User;

        $auth = $user->find($auth_id);

        $dob = $profile['dob'];
        $dob = date($dob['year'] .'-'. $dob['month'].'-'.$dob['day']);

        $auth->update([

            'first_name'         => $profile['first_name'],
            'last_name'          => $profile['last_name'],
            'middle_name'        => $profile['middle_name'],
            'phone'              => $profile['phone'],
            'alt_phone'          => $profile['alt_phone'],
            'email'              => $profile['email'],
            'alt_email'          => $profile['alt_email'],
            'gender'             => $profile['gender'],
            'dob'                => $dob,
            'security_question1' => $profile['security_question1'],
            'security_question2' => $profile['security_question2'],
            'security_answer1'   => $profile['security_answer1'],
            'security_answer2'   => $profile['security_answer2'],
            'language'           => $profile['language'],

        ]);

        $auth->address()->update([
            'address'            => $profile['address'],
            'address2'           => $profile['address2'],
            'city'               => $profile['city'],
            'state'              => $profile['state'],
            'zipcode'            => $profile['zipcode']
        ]);

        return response()->json(['status' => 200]);
    }
    
}

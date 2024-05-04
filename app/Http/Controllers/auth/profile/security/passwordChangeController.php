<?php

namespace App\Http\Controllers\auth\profile\security;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class passwordChangeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user = $request->user();

        if($user->email == $request->email)
        {
            return "You did not changed your email";
        }

        $validator = $this->validatePasswords($request);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()], 422);
        }

        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return "Password updated";

    }

    public function validatePasswords(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'         => [
                'required',
                'between:8,25',
                function($attribute, $value, $fail)  use ($request) {
                    if(!Hash::check($value, $this->userPassword($request->user()))) {
                        $fail('Old password is incorrect');
                    }
                }
            ],
            'new_password'         => 'required|between:8,25',
            'confirm_new_password' => [
                'required',
                'between:8,25',
                function($attribute, $value, $fail) use($request) {
                    if($value !== $request->new_password) {
                        $fail('Passwords does not match');
                    }
                }
            ]
        ]);

        return $validator;

    }

    public function userPassword(User $user)
    {
        return $user->password;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\auth\profile\security;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class emailChangeController extends Controller
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

        $validator = $this->validateEmail($request);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()], 422);
        }

        $user->update([
            'email' => $request->email
        ]);

        return "Email updated";

    }

    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required|unique:users',
            'password' => [
                function($attribute, $value, $fail)  use ($request) {
                    if(!Hash::check($value, $this->userPassword($request->user()))) {
                        $fail('Password is incorrect');
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

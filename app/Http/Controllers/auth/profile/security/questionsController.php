<?php

namespace App\Http\Controllers\auth\profile\security;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class questionsController extends Controller
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

        $validator = $this->validateQuestions($request);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()], 422);
        }

        $user->update([
            'security_question1' => $request->security_question1,
            'security_question2' => $request->security_question2,
            'security_answer1'   => $request->security_answer1,
            'security_answer2'   => $request->security_answer2,
        ]);

        return "Questions saved";

    }

    public function validateQuestions(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'security_question1' => [
                function($attribute, $value, $fail) use ($request) {
                    if($value == '0' && $request->security_answer1 != '') {
                        $fail('Please choose question');
                    }
                }
            ],

            'security_question2' => [
                function($attribute, $value, $fail) use ($request) {
                    if($value == '0' && $request->security_answer2 != '') {
                        $fail('Please choose question');
                    }
                }
            ],


            'security_answer1' => [
                function($attribute, $value, $fail) use ($request) {
                    if($value == '' && $request->security_question1 != '0') {
                        $fail('Please enter answer');
                    }
                }
            ],

            'security_answer2' => [
                function($attribute, $value, $fail) use ($request) {
                    if($value == '' && $request->security_question2 != '0') {
                        $fail('Please enter answer');
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

<?php

namespace App\Http\Controllers\auth\profile;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class basicsController extends Controller
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
    public function update(Request $request, User $user)
    {

        $user = $request->user();

        $this->validateBasics($request);

        $dob = $this->formattedDate($request);

        $user->update([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'middle_name' => $request->middle_name,
            'dob'         => $dob,
            'phone'       => $request->phone,
            'gender'      => $request->gender,
            'alt_phone'   => $request->alt_phone,
            'language'    => $request->language
        ]);

        return "Profile updated";

    }

    public function formattedDate(Request $request)
    {
        return date($request->year . '-' . $request->month . '-' . $request->day);
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

    public function validateBasics(Request $request)
    {
        return $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'gender'     => Rule::notIn('0'),
            'day'        => Rule::notIn('0'),
            'month'      => Rule::notIn('0'),
            'year'       => Rule::notIn('0'),
            'phone'      => 'required',
            'language'   => [
                function($attr, $value, $fail) {
                    if($value != 0 && !Rule::exists('languages', 'id')) {
                        $fail("Please enter valid language");
                    }
                }
            ]
        ]);
    }

}

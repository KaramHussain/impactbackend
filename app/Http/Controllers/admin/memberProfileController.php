<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\carepays_providers\practise;
use App\Http\Controllers\Controller;

class memberProfileController extends Controller
{

    public function __construct() 
    {
        // $this->middleware(['auth:admins']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = (new membersController)->get_members_from_edi($request);
        $members = gettype($members) === 'string' ? json_decode($members, false) : $members;
        if(!count($members)) return [];
        $practise_stats = (array) collect($members)->where('PROVIDER_ID', $request->id)->first();
        $practise_details = practise::with(['providers', 'providers.roles'])->find($request->id)->toArray();
        return response()->json(array_merge($practise_details, $practise_stats));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\claims;

use App\claims\claim_dx_pointer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class claimDxPointersController extends Controller
{
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
    public function store($claim, $treatment, Request $request)
    {
        $dxs = $request->diagnoses[0];
        claim_dx_pointer::create([
            'claim_id' => $claim->id,
            'treatment_id' => $treatment->id,
            'dx1' => isset($dxs[1]) ? $dxs[1]['dx'] : '',
            'dx2' => isset($dxs[2]) ? $dxs[2]['dx'] : '',
            'dx3' => isset($dxs[3]) ? $dxs[3]['dx'] : '',
            'dx4' => isset($dxs[4]) ? $dxs[4]['dx'] : '',
            'dx5' => isset($dxs[5]) ? $dxs[5]['dx'] : '',
            'dx6' => isset($dxs[6]) ? $dxs[6]['dx'] : '',
            'dx7' => isset($dxs[7]) ? $dxs[7]['dx'] : '',
            'dx8' => isset($dxs[8]) ? $dxs[8]['dx'] : '',
            'dx9' => isset($dxs[9]) ? $dxs[9]['dx'] : '',
            'dx10' => isset($dxs[10]) ? $dxs[10]['dx'] : '',
            'dx11' => isset($dxs[11]) ? $dxs[11]['dx'] : '',
            'dx12' => isset($dxs[12]) ? $dxs[12]['dx'] : '',

        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\claims\claim_dx_pointer  $claim_dx_pointer
     * @return \Illuminate\Http\Response
     */
    public function show(claim_dx_pointer $claim_dx_pointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\claims\claim_dx_pointer  $claim_dx_pointer
     * @return \Illuminate\Http\Response
     */
    public function edit(claim_dx_pointer $claim_dx_pointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\claims\claim_dx_pointer  $claim_dx_pointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, claim_dx_pointer $claim_dx_pointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\claims\claim_dx_pointer  $claim_dx_pointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(claim_dx_pointer $claim_dx_pointer)
    {
        //
    }
}

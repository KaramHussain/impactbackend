<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\carepays_providers\practise;
use App\Http\Controllers\Controller;

class chartsController extends Controller
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
        $data = $this->get_chart_data($request);
        $data = gettype($data) === 'string' ? json_decode($data, false) : $data;
        $practises = $this->get_practises_details(collect($data)->pluck('PROVIDER_ID'));
        return response()->json($this->merge_chart_data_with_practise($data, $practises));
    }

    protected function merge_chart_data_with_practise($data, $practises) 
    {
        $filtered_data = [];
        $practises->each(function($practise) use (&$filtered_data, $data) {
            $key = array_search($practise->id, array_column($data, 'PROVIDER_ID'));
            if($key !== false) 
            {
                $filtered_data []= array_merge( (array) $data[$key], ['practice_name' => $practise->name]);
            }
        });
        return $filtered_data;
    }

    protected function get_practises_details($practise_ids) 
    {
        return practise::with(['providers', 'providers.roles'])->whereIn('id', $practise_ids)->get(['id', 'name']);
    }

    protected function get_chart_data(Request $request) 
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph-stage.savibenefits.com/get_everything');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request->all()));

        return curl_exec($ch);
        curl_close($ch);
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

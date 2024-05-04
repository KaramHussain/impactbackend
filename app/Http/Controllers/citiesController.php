<?php

namespace App\Http\Controllers;

use App\city;
use Illuminate\Http\Request;

class citiesController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json(city::where('state_id', $request->state_id)->get());

        return response()->json(city::all());
    }
}

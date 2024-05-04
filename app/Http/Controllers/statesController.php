<?php

namespace App\Http\Controllers;

use App\state;

class statesController extends Controller
{
    public function index()
    {
        return response()->json(state::all());
    }
}

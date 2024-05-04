<?php

namespace App\Http\Controllers\auth\profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\claims\claim;
use App\Http\Resources\eobs\eobResource;

class eobsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request)
    {

        $auth = $request->user();
        $claims = $auth->claims()->paginate();
        return eobResource::collection($claims);

    }

    public function show(claim $claim)
    {
        return response()->json($claim);
    }

}

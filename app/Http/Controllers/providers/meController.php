<?php

namespace App\Http\Controllers\providers;

use App\Http\Controllers\Controller;
use App\Http\Resources\providers\providerResource;
use Illuminate\Http\Request;

class meController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:providers']);
    }

    public function me(Request $request)
    {
        return new providerResource($request->user());
    }

}

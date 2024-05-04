<?php

namespace App\Http\Controllers\providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class logoutController extends Controller
{
    public function logout(Request $request)
    {
        auth('providers')->logout();
    }
}

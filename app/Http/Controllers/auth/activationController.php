<?php

namespace App\Http\Controllers\Auth;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class activationController extends Controller
{
    public function activate(Request $request)
    {
        $db = DB::table('users');

        $user = $db->where('activation_token', $request->token)->whereNotNull('activation_token')->where('email', $request->email)->first();

        if($user)
        {
            $db->where('id', $user->id)->update([
                'activation_token' => null,
                'active'           => 1
            ]);
            return response()->json([200]);
        }

        return response()->json([422]);
    }
}

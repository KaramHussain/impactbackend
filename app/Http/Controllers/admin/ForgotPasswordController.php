<?php

namespace App\Http\Controllers\admin;

use DB;
use App\admin\admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Admin\sendPasswordLink;

class forgotPasswordController extends Controller
{

    public function sendResetPasswordLink(Request $request)
    {
        $this->validateForgotPasswordRequest($request);

        $db = DB::table('password_resets');

        $expired = $this->getExpiryTime();

        $insertion = $db->insert([
            'email' => $request->email,
            'token' => Str::random(255),
            'created_at' => date('Y-m-d H:m:s'),
            'expired_at' => $expired // 60 mins expiry time
        ]);

        if($insertion)
        {
            $details = $db->where('email', $request->email)->get()->first();
            $this->fireForgotPasswordEvent($details);
        }

        return response()->json([200]);

    }

    public function fireForgotPasswordEvent($details)
    {
        event(new sendPasswordLink($details));
    }

    public function validateForgotPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins'
        ], [
            'email.exists' => 'Sorry we could not found that email'
        ]);
    }

    public function getExpiryTime()
    {
        $time = strtotime(date('h:i:s')) + 3600;
        return date('h:i:s', $time);
    }

    public function resetPassword(Request $request)
    {
        $this->validateResetPassword($request);

        $details = $this->tokenWithEmailExists($request);
        if($details)
        {
            $admin = admin::where('email', $request->email)->first();
            
            if(!empty($admin))
            {
                $admin->update([
                    'password' => bcrypt($request->password)
                ]);
                DB::table('password_resets')->where('email', $request->email)
                ->where('token', $request->token)->delete();
                return response()->json(200);
            }
        }
        return abort(401);
    }

    public function checkIfResetTokenExists(Request $request)
    {
        $details = $this->tokenWithEmailExists($request);
        if(!is_null($details)) return response()->json(200);
        return abort(401, "You are unauthorized");
    }

    public function tokenWithEmailExists(Request $request)
    {
        $db = DB::table('password_resets');
        $details =
        $db->where('email', $request->email)
        ->where('token', $request->token)->whereNotNull('token')->first();
        return $details;
    }

    public function validateResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'email'    => 'required|email|exists:providers,email',
            'token'    => 'required'
        ]);
    }

}

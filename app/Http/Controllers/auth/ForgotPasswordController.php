<?php

namespace App\Http\Controllers\Auth;

use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\user\ResetPasswordLink;
use App\Http\Controllers\auth\resendActivationController;

class ForgotPasswordController extends Controller
{
    public function sendResetPasswordLink(Request $request)
    {

        //because validation is same for resend and forgot password
        $resendController = new resendActivationController;
        $resendController->validateResendRequest($request);

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
            $event = new ResetPasswordLink($details);
            event($event);
        }

        return response()->json([200]);

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

            DB::table('password_resets')->where('email', $request->email)
            ->where('token', $request->token)->delete();

            $db = DB::table('users');

            $user = $db->where('email', $request->email)->get();

            if(!empty($user))
            {
                $db->where('email', $request->email)->update([
                    'password' => bcrypt($request->password)
                ]);
                return response()->json([200]);
            }
        }
        return abort(401);
    }

    public function checkIfResetTokenExists(Request $request)
    {
        $details = $this->tokenWithEmailExists($request);
        if($details->count())
        {
            return response()->json(200);
        }
        return response()->json(401);
    }

    public function tokenWithEmailExists(Request $request)
    {
        $db = DB::table('password_resets');
        $details =
        $db->where('email', $request->email)
        ->where('token', $request->token)->whereNotNull('token')->get();
        return $details;
    }

    public function validateResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'email'    => 'required|email|exists:users,email',
            'token'    => 'required'
        ]);
    }

}
<?php

namespace App\Http\Controllers\providers;

use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\providers\sendForgotPasswordLink;

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
        event(new sendForgotPasswordLink($details));
    }

    public function validateForgotPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:providers,email'
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

            DB::table('password_resets')->where('email', $request->email)
            ->where('token', $request->token)->delete();

            $db = DB::table('providers');

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
            'email'    => 'required|email|exists:providers,email',
            'token'    => 'required'
        ]);
    }

}

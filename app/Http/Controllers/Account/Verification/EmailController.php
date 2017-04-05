<?php

namespace App\Http\Controllers\Account\Verification;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    /**
     *  Verify user's email address.
     * 
     *  @param  string $token
     *  @return [type]
     */
    public function verify($token)
    {
        $user = User::whereEmailVerificationToken($token)->first();

        if (is_null($user)) {
            return redirect('/home')->with('message', 'The email confirmation link you followed has expired.Click "Resend confirmation" from Settings for a new one.');
        }

        $user->verifyEmail();

        return redirect('/home')->with('message', 'Your account is now verified.');
    }
}

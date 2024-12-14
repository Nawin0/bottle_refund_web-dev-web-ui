<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected function resetPassword($request, $pass)
    {
        $request->pass = Hash::make($pass);
        $request->save();

        Auth::guard()->login($request);
    }


    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pass' => 'required|confirmed',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member) {
            return back()->withErrors(['email' => 'Email does not exist.']);
        }

        $this->resetPassword($member, $request->pass);

        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }


    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    protected $redirectTo = RouteServiceProvider::HOME;
}

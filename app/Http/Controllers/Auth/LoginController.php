<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone_no' => 'required|string',
            'pass' => 'required|string',
        ]);

        $member = Member::where('phone_no', $request->phone_no)->first();

        if ($member && Hash::check($request->pass, $member->pass)) {
            Auth::login($member);

            if ($member->level == 1) {
                return redirect()->route('user.new');  
            } elseif ($member->level == 2) {
                return redirect()->route('admin.dashboard'); 
            }
        }

        return redirect()->back()->withErrors([
            'phone_no' => 'The provided credentials are incorrect.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

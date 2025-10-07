<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = Auth::user();

        if ($user->otp_code === $request->otp) {
            $user->is_verified = true;
            $user->otp_code = null; // Clear the OTP after successful verification
            $user->save();

            return redirect()->intended('/admin')->with('success', 'OTP verified successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid OTP code. Please try again.']);
    }
}

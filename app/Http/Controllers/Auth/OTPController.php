<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    public function newOTP(Request $request){
        $user = auth()->user();
        if (!$user->is_verified) {
            // Generate and save an OTP
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->save();

// Define the Zamtel API details
            $apiKey = "8mybEVy6oOnRBDhUiRkfhGfgvUzRvaze"; // Replace with your actual API key
            $senderId = "PPMSLOTP";  // Replace with your approved Sender ID
            $phoneNumber = $user->phone;  // User's phone number in international format (e.g., 260950003929)
            $message = urlencode("Your OTP code is: $otp");
            \App\Models\User::sendMail($otp);

// Construct the API URL
            $apiUrl = "https://bulksms.zamtel.co.zm/api/v2.1/action/send/api_key/$apiKey/contacts/$phoneNumber/senderId/$senderId/message/$message";

// Send the SMS using cURL
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPGET => true,
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

// Check the response
            if ($httpCode == 200) {
                // Success: Log or perform additional actions
                Log::info("SMS sent successfully to $phoneNumber. Response: $response");
            } else {
                // Failure: Log or handle the error
                Log::error("Failed to send SMS to $phoneNumber. HTTP Code: $httpCode. Response: $response");
            }

            return back();
        }else{
            redirect()->to('/admin/login')->with('error','err');
        }

        return null;
    }
    public function Back(){
        auth()->logout();
        return redirect()->to('/admin/login');
    }
}

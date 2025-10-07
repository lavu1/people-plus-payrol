<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Page;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function authenticate(): null
    {
        parent::authenticate();

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

// Redirect to OTP verification page
            //redirect()->to('/otp')->send();
            redirect()->to('/otp')->with('error','err');//->send();

        }else{
            redirect()->to('/otp')->with('error','err');
        }

        return null;
    }
}
/*
class Login extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.login';


}
*/

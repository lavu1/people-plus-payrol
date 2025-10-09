<?php

namespace App\Observers;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        /*
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->save();

        $details = [
            'subject' => 'OTP',
            'name' => $user->name,
            'OTP' => $otp
        ];

        //  Mail::to($user->email)->send(new ESendMail($details));
        Mail::to($user->email)->send(new SendMail($details));
*/
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

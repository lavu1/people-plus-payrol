<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $otp = rand(100000, 999999);
//        $user->otp_code = $otp;
//        $user->save();
//
        // Generate and set OTP values
        $data['otp_code'] = $otp;
        \App\Models\User::sendMail($otp);
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {

        $otp = rand(100000, 999999);
//        $user->otp_code = $otp;
//        $user->save();
//
        // Generate and set OTP values
        $data['otp_code'] = $otp;
        \App\Models\User::sendMail($otp);
        $user = parent::handleRecordCreation($data);
        return $user;
    }

    protected static string $resource = UserResource::class;
}

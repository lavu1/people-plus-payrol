<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Page;

class OTPVerification extends Page
{
//    protected static string $resource = UserResource::class;
//
//    protected static string $view = 'filament.resources.user-resource.pages.pages.o-t-p-verification.php';

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed'; // Optional: Icon for the navigation if needed.
    protected static string $view = 'filament.pages.otp-verification';

    // Optionally disable navigation if this is not a menu item.
    protected static bool $shouldRegisterNavigation = false;
}

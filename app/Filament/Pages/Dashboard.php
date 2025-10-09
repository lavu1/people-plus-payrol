<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CompanyEmployeeResource\Widgets\Stats\UsersStats;
use App\Filament\Resources\GratuityResource\Widgets\UserDataChart;
use App\Filament\Resources\GratuityResource\Widgets\UserPayrollBarChart;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Support\Facades\Auth;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    //protected static string $view = 'filament.pages.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            UsersStats::class,
            UserPayrollBarChart::class,
            UserDataChart::class
        ];
    }

    public function mount()
    {

        if (!auth()->user()->is_verified && auth()->user()->otp_code != '') {
            // Redirect to a verification page or display a notification
            return redirect()->route('otp.page');
            // Or:
            // return $this->notify('danger', 'Please verify your account.');
        } else if (!auth()->user()->is_verified && auth()->user()->otp_code == '') {
            //dd((auth()->user()->is_verified || !auth()->user()->is_verified && auth()->user()->otp_code == ''));
            $user = Auth::user();
                $user->is_verified = true;
                $user->otp_code = '';
                $user->save();
            auth()->logout();
            return redirect()->to('/admin/login');

        }
    }
}

<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CompanyEmployeeResource\Widgets\Stats\UsersStats;
use App\Filament\Resources\GratuityResource\Widgets\UserDataChart;
use App\Filament\Resources\GratuityResource\Widgets\UserPayrollBarChart;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

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
        if (!auth()->user()->is_verified) {
            // Redirect to a verification page or display a notification
            return redirect()->route('otp.page');
            // Or:
            // return $this->notify('danger', 'Please verify your account.');
        }
    }
}

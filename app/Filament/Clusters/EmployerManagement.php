<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class EmployerManagement extends Cluster
{
    //protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase'; // Choose an appropriate icon

    protected static ?string $navigationLabel = 'Employer Management';

    protected static ?int $navigationSort = -100; //Ensure it appears first

    public static function navigationGroup(): ?string
    {
        return null;
    }
}

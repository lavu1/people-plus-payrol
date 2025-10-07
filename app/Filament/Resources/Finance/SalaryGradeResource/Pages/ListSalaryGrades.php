<?php

namespace App\Filament\Resources\Finance\SalaryGradeResource\Pages;

use App\Filament\Resources\Finance\SalaryGradeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalaryGrades extends ListRecords
{
    protected static string $resource = SalaryGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

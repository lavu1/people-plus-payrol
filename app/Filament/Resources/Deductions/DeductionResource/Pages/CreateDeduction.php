<?php

namespace App\Filament\Resources\Deductions\DeductionResource\Pages;

use App\Filament\Resources\Deductions\DeductionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateDeduction extends CreateRecord
{

    protected function handleRecordCreation(array $data): Model
    {
        $positions = $data['position_id'];
        unset($data['position_id']);

        return DB::transaction(function () use ($data, $positions) {
            $allowances = [];

            foreach ($positions as $positionId) {
                $allowances[] = [
                    ...$data,
                    'position_id' => $positionId,
                    'company_id' => Auth::user()->current_company_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Bulk insert all allowance records
            static::getModel()::insert($allowances);

            // Return the first one (for Filament's redirect)
            return static::getModel()::where('position_id', $positions[0])
                ->where('name', $data['name'])
                ->first();
        });
    }
    protected static string $resource = DeductionResource::class;
}

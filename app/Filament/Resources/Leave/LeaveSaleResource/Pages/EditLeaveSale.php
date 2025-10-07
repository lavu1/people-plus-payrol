<?php

namespace App\Filament\Resources\Leave\LeaveSaleResource\Pages;

use App\Filament\Resources\Leave\LeaveSaleResource;
use App\Models\Leave\LeaveBalance;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLeaveSale extends EditRecord
{
    protected function handleRecordUpdate($record, $data): Model
    {
        //dd($data);
        $record->update($data);
        if ($data['status'] == 'Approved') {

            // Get the employee's leave balance
            $employee = LeaveBalance::where('company_employee_id', $data['company_employee_id'])->first();

            if ($employee) {
                $employee->balance -= $data['leave_days_sold'];

                // Ensure leave balance doesn't go negative (optional)
                if ($employee->balance < 0) {
                    $employee->balance = 0; // or handle the error appropriately
                }

                $employee->save();
            } else {
                // Handle the case where the employee is not found
                // Log an error, display a message, etc.
                \Log::error("Employee not found with ID: " . $data['company_employee_id']);
            }
        }
        return $record;
    }
    protected static string $resource = LeaveSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

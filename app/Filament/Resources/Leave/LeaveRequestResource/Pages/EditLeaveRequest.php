<?php

namespace App\Filament\Resources\Leave\LeaveRequestResource\Pages;

use App\Filament\Resources\Leave\LeaveRequestResource;
use App\Models\Leave\LeaveBalance;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLeaveRequest extends EditRecord
{
    protected function handleRecordUpdate($record, $data): Model
    {
        $record->update($data);
        if ($data['status'] == 'Approved') {
            $startDate = Carbon::parse($data['start_date']);
            $endDate = Carbon::parse($data['end_date']);

            // Calculate the number of days, including the start and end dates.
            $numberOfDays = $startDate->diffInDays($endDate) + 1;
            //dd($numberOfDays);
            // Get the employee's leave balance
            $employee = LeaveBalance::where('company_employee_id',$data['company_employee_id'])->first();

            if ($employee) {
                $employee->balance -= $numberOfDays;

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
    protected static string $resource = LeaveRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

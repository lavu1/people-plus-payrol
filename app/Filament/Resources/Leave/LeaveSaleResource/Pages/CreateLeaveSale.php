<?php

namespace App\Filament\Resources\Leave\LeaveSaleResource\Pages;

use App\Filament\Resources\Leave\LeaveSaleResource;
use App\Models\Leave\LeaveBalance;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLeaveSale extends CreateRecord
{
    protected function handleRecordCreation(array $data): Model
    {

//        dd($data);

        //insert the student
        $record =  static::getModel()::create($data);

        if ($data['status'] == 'Approved') {
            // Get the employee's leave balance
            $employee = LeaveBalance::where('company_employee_id',$data['company_employee_id'])->first();

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
        /*
                // Create a new Guardian model instance
                $guardian = new Guardian();
                $guardian->first_name = $data['guardian_fname'];
                $guardian->last_name = $data['guardian_lname'];
                $guardian->gender = $data['guardian_gender'];
                $guardian->email = $data['guardian_email'];
                $guardian->contact_no = $data['guardian_contact'];

                // Assuming 'student_id' is the foreign key linking to students
                $guardian->student_id = $record->student_id;

                // Save the Guardian model to insert the data
                $guardian->save();
                */


        return $record;

    }
    protected static string $resource = LeaveSaleResource::class;
}

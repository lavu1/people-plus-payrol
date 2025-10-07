<?php

namespace App\Filament\Resources\Payroll\PayrollResource\Pages;

use App\Filament\Resources\Payroll\PayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePayroll extends CreateRecord
{
    protected function handleRecordCreation(array $data): Model
    {

//        dd($data);

        //insert the student
        $record =  static::getModel()::create($data);
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

    protected static string $resource = PayrollResource::class;
}

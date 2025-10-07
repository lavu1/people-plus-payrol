<?php

namespace App\Filament\Resources\Payroll\PayrollResource\Pages;

use App\Filament\Resources\Payroll\PayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPayroll extends EditRecord
{
    protected static string $resource = PayrollResource::class;

protected function handleRecordUpdate($record, $data): Model
{
    $record->update($data);
    /*
    DB::beginTransaction();
    //insert the student
    $record =  static::getModel()::create($data);
    //$record =  static::getModel()::create($data);
    //$record = static::getModel()::update($record,$data);
    $record->update($data);
//
//        protected function handleRecordUpdate(Model $record, array $data): Model
//    {
        $record->update($data);
//
//        return $record;
//    }

   // $this->handleRecordUpdate($this->getRecord(), $data);
    $deductions = Deduction::get();

//        Model $record, array $data): Model
//    {
//        $record->update($data);

    // Create a new Guardian model instance
    $guardian = new Guardian();
    $guardian->first_name = $data['guardian_fname'];
    $guardian->last_name = $data['guardian_lname'];
    $guardian->gender = $data['guardian_gender'];
    $guardian->email = $data['guardian_email'];
    $guardian->contact_no = $data['guardian_contact'];
    $guardian = new Deduction();
//        $guardian->first_name = $data['guardian_fname'];
//        $guardian->last_name = $data['guardian_lname'];
//        $guardian->gender = $data['guardian_gender'];
//        $guardian->email = $data['guardian_email'];
//        $guardian->contact_no = $data['guardian_contact'];

    // Assuming 'student_id' is the foreign key linking to students
    $guardian->student_id = $record->student_id;
   // $guardian->student_id = $record->student_id;

    // Save the Guardian model to insert the data
    $guardian->save();

    //$guardian->save();

    DB::commit();
    */
    return $record;


}

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

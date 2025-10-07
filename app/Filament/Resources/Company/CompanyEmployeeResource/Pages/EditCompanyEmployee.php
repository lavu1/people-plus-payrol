<?php

namespace App\Filament\Resources\Company\CompanyEmployeeResource\Pages;

use App\Filament\Resources\Company\CompanyEmployeeResource;
use App\Models\Company\Contact;
use App\Models\Company\Identification;
use App\Models\Company\NextOfKin;
use App\Models\Finance\EmployeeBankAccount;
use Filament\Resources\Pages\EditRecord;

class EditCompanyEmployee extends EditRecord
{
    protected static string $resource = CompanyEmployeeResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {

        //$data['identification']['identification_type'] = $data['identification']['identification_type'][0];



        // Get the employee record being edited
        $employee = $this->record;

        // Update bank account
        if (isset($data['bank_account'])) {
            EmployeeBankAccount::find($employee->employee_bank_account_id)->update($data['bank_account']);
            unset($data['bank_account']);
        }

        // Update contacts
        if (isset($data['contacts'])) {
            unset($data['contacts']['province_id']);
            Contact::find($employee->user->contact_id)->update($data['contacts']);
            unset($data['contacts']);
        }

        // Update next of kin
        if (isset($data['next_of_kin'])) {
            NextOfKin::find($employee->user->next_of_kin_id)->update($data['next_of_kin']);
            unset($data['next_of_kin']);
        }

        // Update identification
        if (isset($data['identification'])) {
            Identification::find($employee->user->identification_id)->update($data['identification']);
            unset($data['identification']);
        }

        // Update user if needed
        if (isset($data['user'])) {
            $employee->user->update([
                'name' => $data['user']['name'],
                // Add other user fields as needed
            ]);
            unset($data['user']);
        }

        return $data;
    }
}

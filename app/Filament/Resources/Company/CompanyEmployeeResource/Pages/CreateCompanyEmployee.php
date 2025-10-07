<?php

namespace App\Filament\Resources\Company\CompanyEmployeeResource\Pages;

use App\Filament\Resources\Company\CompanyEmployeeResource;
use App\Models\Company\Contact;
use App\Models\Company\Identification;
use App\Models\Company\NextOfKin;
use App\Models\Finance\EmployeeBankAccount;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateCompanyEmployee extends CreateRecord
{
    protected static string $resource = CompanyEmployeeResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {


        try {

            DB::beginTransaction();
            // Create a user first
            $user = User::create([
                'name' => $data['user']["name"],
                'email' => $data['email'],
                'gender' => $data['gender'],
                'marital_status' => $data['marital_status'],
                'password' => Hash::make('password@' . $data['user']['name']),
                'current_company_id' => Auth::user()->current_company_id,
            ]);

            // Attach the user_id to the employee data
            $data['user_id'] = $user->id;

            // Remove the email from the employee data since it's not needed
            unset($data['email']);
            unset($data['contacts']['province_id']);
            unset($data['next_of_kin']['province_id']);


            // create bank account
           // dd($data['bank_account']);
            $account = EmployeeBankAccount::create($data['bank_account']);
            $data['employee_bank_account_id'] = $account->id;



            // create contacts
            $contact = Contact::create($data['contacts']);
            $data['contact_id'] = $contact->id;

            // create next of kin
            $nextofkin = NextOfKin::create($data['next_of_kin']);
            $data['next_of_kin_id'] = $nextofkin->id;

            // create identification
            $identification = Identification::create($data['identification']);
            $data['identification_id'] = $identification->id;

            // update user information
            $user->update(['identification_id' => $data['identification_id'], 'next_of_kin_id' => $data['next_of_kin_id'], 'contact_id' => $data['contact_id']]);
           
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        //DB::commit();

        return $data;
    }
}

<?php

namespace App\Observers\Employee;

use App\Models\Allowance\Allowance;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Deduction;
use App\Models\User;

class EmployeeObserver
{
    /**
     * Handle the ComoanyEmployee "created" event.
     */
    public function created(CompanyEmployee $companyEmployee): void
    {
        $this->createAllowance($companyEmployee);
        $this->createDeduction($companyEmployee);
    }

    /**
     * Handle the ComoanyEmployee "updated" event.
     */
    public function updated(CompanyEmployee $companyEmployee): void
    {
        //dd($companyEmployee);
        $this->createAllowance($companyEmployee);
        $this->createDeduction($companyEmployee);
    }

    /**
     * Handle the ComoanyEmployee "deleted" event.
     */
    public function deleted(CompanyEmployee $companyEmployee): void
    {
        //
    }

    /**
     * Handle the ComoanyEmployee "restored" event.
     */
    public function restored(CompanyEmployee $companyEmployee): void
    {
        //
    }

    /**
     * Handle the ComoanyEmployee "force deleted" event.
     */
    public function forceDeleted(CompanyEmployee $companyEmployee): void
    {
        //
    }
    public function createAllowance(CompanyEmployee $companyEmployee): void
    {

        $user_id = User::find($companyEmployee->user_id);
        //dd($user_id);
        Allowance::updateOrCreate(
            [
                'company_id' => $user_id->current_company_id,
                'position_id' => $companyEmployee->position_id,
            ],
            [
                'recurring' => 1, // Total
                'is_taxable' => 1,
                'status' => 1,
                'description' => 'Housing Allowance',
                'value' => 15,
                'allowance_type' => 'percentage',
                'allowance_name' => 'Housing Allowance',
            ]
        );

        Allowance::updateOrCreate(
            [
                'company_id' => $user_id->current_company_id,
                'position_id' => $companyEmployee->position_id,
            ],
            [
                'recurring' => 1, // Total
                'is_taxable' => 1,
                'status' => 1,
                'description' => 'Transport Allowance',
                'value' => 15,
                'allowance_type' => 'percentage',
                'allowance_name' => 'Transport Allowance',
            ]
        );

    }
    public function createDeduction(CompanyEmployee $companyEmployee): void{

        $salary = $companyEmployee->salary;

// PAYE Tax Brackets (2024)
        $payeTax = 0;
        if ($salary > 8000) {
            $payeTax = ($salary - 8000) * 0.375 + 1200; // Above ZMW 8000
        } elseif ($salary > 4700) {
            $payeTax = ($salary - 4700) * 0.3 + 405; // ZMW 4700 - ZMW 8000
        } elseif ($salary > 4100) {
            $payeTax = ($salary - 4100) * 0.25 + 280; // ZMW 4100 - ZMW 4700
        } elseif ($salary > 3900) {
            $payeTax = ($salary - 3900) * 0.2 + 240; // ZMW 3900 - ZMW 4100
        } elseif ($salary > 0) {
            $payeTax = 0; // Below ZMW 3900 is tax-free
        }

// NAPSA Contribution (5% capped at 1,496.75)
        $napsaContribution = min($salary * 0.05, 1496.75);
        $user_id = User::find($companyEmployee->user_id);
// Store PAYE Deduction
        Deduction::updateOrCreate(
            [
                'company_id' => $user_id->current_company_id,
                'position_id' => $companyEmployee->position_id,
                'frequency' => 'Monthly',
                'name' => 'PAYE'
            ],
            [
                'd_type' => 'fixed',
                'value' => $payeTax,
                'is_statutory' => 1,
                'destination' => 'ZRA'
            ]
        );

// Store NAPSA Deduction
        Deduction::updateOrCreate(
            [
                'company_id' => $user_id->current_company_id,
                'position_id' => $companyEmployee->position_id,
                'frequency' => 'Monthly',
                'name' => 'NAPSA'
            ],
            [
                'd_type' => 'fixed',
                'value' => $napsaContribution,
                'is_statutory' => 1,
                'destination' => 'Pension'
            ]
        );

        $grade = Deduction::updateOrCreate(
            [
                'company_id' => $user_id->current_company_id,
                'position_id' => $companyEmployee->position_id,
                'frequency' => 'Monthly',
                'name' => 'Nhima', // Total
            ],
            [
                'd_type' => 'percentage',
                'value' => 1.5,
                'is_statutory' => 1,
                'destination' => 'Nhima'
            ]
        );
    }
}

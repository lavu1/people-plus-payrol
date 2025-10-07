<?php

namespace App\Models\Company;

use App\Models\Allowance\EmployeeAllowance;
use App\Models\Bank\Bank;
use App\Models\Bank\BankBranch;
use App\Models\Finance\Currency;
use App\Models\Finance\EmployeeBankAccount;
use App\Models\Finance\PaymentMethod;
use App\Models\Finance\SalaryGrade;
use App\Models\Finance\Saving;
use App\Models\Payroll\PayrollTransactions;
use App\Models\Residency\Country;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Termwind\Repositories\Styles;

class CompanyEmployee extends Model
{
    protected $fillable = [

        'date_of_birth',
        'employee_identification_number',
        'salary',
       // 'country_id',
        'department_id',
        'user_id',
        'salary_grade_id',
        'company_employment_type_id',
        'position_id',
        'payment_method_id',
        'currency_id',
        'employee_bank_account_id',
        'employee_mobile_money_account_id',
    ];

/**
     * Scope to filter employees by a specific company.
     */
    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('department.companyBranch', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }

    /**
     * CompanyEmployee belongs to a department.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'current_company_id');
    }

    public function companyBranch()
    {
        return $this->belongsTo(CompanyBranch::class,'company_branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salary_grade()
    {
        return $this->belongsTo(SalaryGrade::class,'salary_grade_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function employment_type()
    {
        return $this->belongsTo(CompanyEmploymentType::class,'company_employment_type_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }




    public function bank_account()
    {
        return $this->belongsTo(EmployeeBankAccount::class);
    }


    public function payrollTransactions()
    {
        return $this->hasMany(PayrollTransactions::class);
    }


    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }


    public function bankBranch()
    {
        return $this->belongsTo(BankBranch::class);
    }


    public function province()
    {
        return $this->belongsTo(Province::class);
    }


    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function employeeAllowances()
    {
        return $this->hasMany(EmployeeAllowance::class, 'company_employee_id');
    }

    public function savings()
    {
        return $this->hasone(Saving::class);
    }

}

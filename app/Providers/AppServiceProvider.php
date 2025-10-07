<?php

namespace App\Providers;

use App\Filament\Resources\UserResource\Pages\OTPVerification;
use App\Listeners\UpdateIsVerifiedOnLogout;
use App\Models\Allowance\Allowance;
use App\Models\Allowance\EmployeeAllowance;
use App\Models\Company\CompanyTransactions;
use App\Models\Finance\AdvanceApplication;
use App\Models\Finance\Deduction;
use App\Models\Finance\DeductionTransaction;
use App\Models\Finance\Employee_Deductions;
use App\Models\Finance\Gratuity;
use App\Models\Finance\GratuityTransactions;
use App\Models\Finance\Payroll;
use App\Models\Finance\PayrollUpload;
use App\Models\Finance\Payslip;
use App\Models\Finance\Saving;
use App\Models\Finance\Savings;
use App\Models\Finance\SavingsApplication;
use App\Models\Finance\SavingsTransaction;
use App\Models\Finance\SavingsTransactions;
use App\Models\Payroll\PayrollTransactions;
use App\Observers\Employee\EmployeeObserver;
use App\Observers\Payroll\PayrollObserver;
use App\Policies\Allowance\AllowancePolicy;
use App\Policies\Allowance\EmployeeAllowancePolicy;
use App\Policies\Payroll\PayrollTransactionsPolicy;
use App\Models\Bank\{Bank, BankBranch};
use App\Models\Company\Company;
use App\Models\Company\CompanyBranch;
use App\Models\Company\CompanyEmployee;
use App\Models\Company\CompanyEmploymentType;
use App\Models\Company\Department;
use App\Models\Company\Position;
use App\Models\Finance\Advance;
use App\Models\Finance\Currency;
use App\Models\Finance\MobileNetworkOperator;
use App\Models\Finance\OverTimeClaim;
use App\Models\Finance\OverTimeConfig;
use App\Models\Finance\OverTimeRequest;
use App\Models\Finance\PaymentMethod;
use App\Models\Finance\SalaryGrade;
use App\Models\Industry\Sector;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveRequest;

use App\Models\Leave\LeaveSale;
use App\Models\Leave\LeaveType;
use App\Models\Residency\Country;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use App\Policies\Bank\{BankPolicy, BankBranchPolicy};
use App\Policies\Company\{CompanyEmployeePolicy,
    CompanyEmploymentTypePolicy,
    CompanyPolicy,
    CompanyBranchPolicy,
    CompanyTransactionsPolicy,
    DepartmentPolicy,
    PositionPolicy};
use App\Policies\Finance\{AdvanceApplicationPolicy,
    AdvancePolicy,
    CurrencyPolicy,
    DeductionPolicy,
    DeductionTransactionPolicy,
    Employee_DeductionsPolicy,
    GratuityPolicy,
    GratuityTransactionPolicy,
    MobileNetworkOperatorPolicy,
    PayrollPolicy,
    PayrollUploadPolicy,
    PayslipPolicy,
    SalaryGradePolicy,
    PaymentMethodPolicy,
    OverTimeClaimPolicy,
    OverTimeConfigPolicy,
    OverTimeRequestPolicy,
    SavingsApplicationPolicy,
    SavingsPolicy,
    SavingsTransactionsPolicy};
use App\Policies\Industry\SectorPolicy;
use Filament\Facades\Filament;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;
use App\Policies\Leave\{LeaveBalancePolicy, LeaveRequestPolicy, LeaveSalePolicy, LeaveTypePolicy};
use App\Policies\Residency\{CountryPolicy, ProvincePolicy, TownPolicy};
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::policy(Bank::class, BankPolicy::class);
        Gate::policy(BankBranch::class, BankBranchPolicy::class);
        Gate::policy(Department::class, DepartmentPolicy::class);
        Gate::policy(Position::class, PositionPolicy::class);
        Gate::policy(Company::class, CompanyPolicy::class);
        Gate::policy(CompanyBranch::class, CompanyBranchPolicy::class);
        Gate::policy(CompanyEmployee::class, CompanyEmployeePolicy::class);
        Gate::policy(CompanyEmploymentType::class, CompanyEmploymentTypePolicy::class);
        Gate::policy(CompanyTransactions::class, CompanyTransactionsPolicy::class);

        Gate::policy(Advance::class, AdvancePolicy::class);
        Gate::policy(Currency::class, CurrencyPolicy::class);
        Gate::policy(MobileNetworkOperator::class, MobileNetworkOperatorPolicy::class);
        Gate::policy(SalaryGrade::class, SalaryGradePolicy::class);
        Gate::policy(PaymentMethod::class, PaymentMethodPolicy::class);

        Gate::policy(OverTimeClaim::class, OverTimeClaimPolicy::class);
        Gate::policy(OverTimeConfig::class, OverTimeConfigPolicy::class);
        Gate::policy(OverTimeRequest::class, OverTimeRequestPolicy::class);

        Gate::policy(Country::class, CountryPolicy::class);
        Gate::policy(Province::class, ProvincePolicy::class);
        Gate::policy(Town::class, TownPolicy::class);

        Gate::policy(Sector::class, SectorPolicy::class);
        Gate::policy(LeaveBalance::class, LeaveBalancePolicy::class);
        Gate::policy(LeaveRequest::class, LeaveRequestPolicy::class);
        Gate::policy(LeaveSale::class, LeaveSalePolicy::class);
        Gate::policy(LeaveType::class, LeaveTypePolicy::class);

        Gate::policy(Allowance::class, AllowancePolicy::class);
        Gate::policy(EmployeeAllowance::class, EmployeeAllowancePolicy::class);

        Gate::policy(Deduction::class, DeductionPolicy::class);
        //Gate::policy(Employee_Deductions::class, Employee_DeductionsPolicy::class);
        Gate::policy(Gratuity::class, GratuityPolicy::class);
        Gate::policy(Payroll::class, PayrollPolicy::class);
        Gate::policy(PayrollUpload::class, PayrollUploadPolicy::class);
        Gate::policy(Payslip::class, PayslipPolicy::class);
        Gate::policy(SavingsApplication::class, SavingsApplicationPolicy::class);
        Gate::policy(Saving::class, SavingsPolicy::class);
        Gate::policy(SavingsTransaction::class, SavingsTransactionsPolicy::class);
        Gate::policy(PayrollTransactions::class, PayrollTransactionsPolicy::class);

        Gate::policy(AdvanceApplication::class, AdvanceApplicationPolicy::class);
        Gate::policy(DeductionTransaction::class, DeductionTransactionPolicy::class);
        Gate::policy(GratuityTransactions::class, GratuityTransactionPolicy::class);



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Custom Filament routes
            Route::middleware(['web', 'auth'])
                ->group(function () {
                    Route::get('/otp', [OTPVerification::class, 'render'])->name('otp.page');
                    Route::post('/otp/verify', [\App\Http\Controllers\Auth\OTPController::class, 'verify'])->name('otp.verify');
                });
        });
        Payroll::observe(PayrollObserver::class);
        CompanyEmployee::observe(EmployeeObserver::class);

    }
}

<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Allowance\EmployeeAllowance;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\AdvanceApplication;
use App\Models\Finance\OverTimeRequest;
use App\Models\Finance\Payroll;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveRequest;
use App\Models\Leave\LeaveSale;
use App\Models\Leave\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class EmployeeController extends Controller

{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            $user = Auth::user()->company();
            // Using Auth facade
            $user = Auth::user()->load('company', 'companyEmployee.department.companyBranch', 'companyEmployee.salary_grade', 'companyEmployee.employment_type', 'companyEmployee.position', 'companyEmployee.currency', 'companyEmployee.paymentMethod', 'contact.town.province.country', 'next_of_kin', 'identification');

            //$user = auth()->user()->load('company');

            $expiresIn = Carbon::now()->addSeconds(60);

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'success' => true,
                'token' => $token,
                'expire_at' => $expiresIn,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
    }

    public function getEarnings()
    {
        $user = Auth::user()->id;
        $employee = CompanyEmployee::where('user_id', $user)->orderBy('id', 'desc')->firstOrFail();

        return response()->json([
            'success' => true,
            'earnings' => EmployeeAllowance::where('company_employee_id', $employee->id)->orderBy('id', 'desc')->with('allowance')->with('payroll')->get()
        ], 200);
    }

    public function getAdvances()
    {
        return response()->json([
            'success' => true,
            'advances' => AdvanceApplication::orderBy('id', 'desc')->get()
        ], 200);
    }

    public function getLeaveRequests()
    {
        $user = Auth::user()->id;
        $users = Auth::user();
        $employee = CompanyEmployee::where('user_id', $user)->firstOrFail();
        $leavebalance = LeaveBalance::where('company_employee_id', $employee->id)->get()->last();
        $leaveTypes = LeaveType::where('company_id', $users->current_company_id)->get();

        return response()->json([
            'success' => true,
            'leaveTypes' => $leaveTypes,
            'leave_balance' => $leavebalance,
            'leaverequests' => LeaveRequest::with('leaveType')->where('company_employee_id', $employee->id)->orderBy('id', 'desc')->get()
        ], 200);
    }

    public function leaveSales()
    {
        $user = Auth::user()->id;
        $users = Auth::user();
        $employee = CompanyEmployee::where('user_id', $user)->firstOrFail();
        $leavebalance = LeaveBalance::where('company_employee_id', $employee->id)->orderBy('id', 'desc')->get()->last();

        return response()->json([
            'success' => true,
            'payroll' => Payroll::where('processed', 0)->where('company_id', $users->current_company_id)->get(),
            'leave_balance' => $leavebalance,
            'leavesales' => LeaveSale::with('payroll')->where('company_employee_id', $employee->id)->get()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function OvertimeRequests()
    {
        $user = Auth::user()->id;
        $employee = CompanyEmployee::where('user_id', $user)->firstOrFail();

        return response()->json([
            'success' => true,
            'overtime' => OverTimeRequest::where('company_employee_id', $employee->id)->orderBy('id', 'desc')->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Payroll()
    {
        $user = Auth::user()->id;
        $users = Auth::user();
        $employee = CompanyEmployee::where('user_id', $user)->firstOrFail();
        $data = Payroll::with([
            'employeeAllowances' => function ($query) use ($employee) {
                $query->where('company_employee_id', $employee->id);
            },
            'employeeDeductions' => function ($query) use ($employee) {
                $query->where('company_employee_id', $employee->id);
            },
            'payrollTransactions' => function ($query) use ($employee) {
                $query->where('company_employee_id', $employee->id);
            }
        ])
            ->whereHas('employeeAllowances', function (Builder $query) use ($employee) {
                $query->where('company_employee_id', $employee->id);
            })
            ->whereHas('employeeDeductions', function (Builder $query) use ($employee) {
                $query->where('company_employee_id', $employee->id);
            })->with('employeeDeductions.deduction','employeeAllowances.allowance')
            ->where('company_id', $users->current_company_id)
            ->orderBy('payrolls.id', 'desc')->get();
        if ($data){
            return response()->json([
                'success' => true,
                'payroll' => $data
        ], 200);
        }else{
            return response()->json([
                'success' => true,
                'payroll' => $data
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function AdvanceApplication(Request $request)
    {
        $users = Auth::user()->id;
        $employee = CompanyEmployee::where('user_id', $users)->firstOrFail();

        $data['company_employee_id'] = $employee->id;
        $data['amount'] = $request->input('amount');
        $data['reason'] = $request->input('reason');
        $data['a_type'] = 'fixed';
        $data['value'] = $request->input('amount');
        $data['frequency'] = $request->input('frequency');
        $data['status'] = 0;
        $createAdvance = AdvanceApplication::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Advance application created successfully',
            'data' => $createAdvance
        ]);
    }

    public function UpdateAdvance(Request $request, string $id)
    {
        $data['amount'] = $request->input('amount');
        $data['reason'] = $request->input('reason');
        $data['frequency'] = $request->input('frequency');
        $updateAdvance = AdvanceApplication::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Advance application updated successfully',
            'data' => $updateAdvance
        ]);
    }

    public function Advancedestroy(string $id)
    {
        $updateAdvance = AdvanceApplication::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Advance application deleted successfully',
        ]);
    }

    public function LeaveApplication(Request $request)
    {
        $users = Auth::user()->id;
        $employee = CompanyEmployee::where('user_id', $users)->firstOrFail();

        $data['company_employee_id'] = $employee->id;
        $data['leave_type_id'] = $request->input('leave_type_id');
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['reason'] = $request->input('reason');
        $data['status'] = 0;
        $create = LeaveRequest::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Leave application created successfully',
            'data' => $create
        ]);
    }

    public function UpdateLeave(Request $request, string $id)
    {
        $data['leave_type_id'] = $request->input('leave_type_id');
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['reason'] = $request->input('reason');

        $updateLeave = LeaveRequest::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Leave application updated successfully',
            'data' => $updateLeave
        ]);
    }

    public function LeaveDestroy(string $id)
    {
        $deleteLeave = LeaveRequest::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Leave application deleted successfully',
        ]);
    }

    public function LeaveSaleApplication(Request $request)
    {
        $users = Auth::user()->id;
        $employee = CompanyEmployee::where('user_id', $users)->firstOrFail();
        $data['company_employee_id'] = $employee->id;
        $data['leave_days_sold'] = $request->input('leave_days_sold');
        $data['sale_amount'] = ($employee->salary * $request->input('leave_days_sold') / 26);
        $data['reason'] = $request->input('reason');
        $data['status'] = 'Pending';
        $create = LeaveSale::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Leave application created successfully',
            'data' => $create
        ]);
    }

    public function UpdateLeaveSale(Request $request, string $id)
    {
        $users = Auth::user()->id;
        $employee = CompanyEmployee::where('user_id', $users)->firstOrFail();
        $data['sale_amount'] = ($employee->salary * $request->input('leave_days_sold') / 26);
        $data['leave_days_sold'] = $request->input('leave_days_sold');
        $data['reason'] = $request->input('reason');

        $updateLeave = LeaveSale::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Leave application updated successfully',
            'data' => $updateLeave
        ]);
    }

    public function LeaveSaleDestroy(string $id)
    {
        $deleteLeave = LeaveSale::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Leave application deleted successfully',
        ]);
    }


    public function OvertimeApplication(Request $request)
    {
        $users = Auth::user()->id;
        $employee = CompanyEmployee::where('user_id', $users)->firstOrFail();
        $data['company_employee_id'] = $employee->id;
        $data['over_time_type'] = $request->input('over_time_type');
        $data['requested_hours'] = $request->input('requested_hours');
        $data['justification'] = $request->input('justification');
        $data['supervisor_triggered'] = 0;
        $data['status'] = 'Pending';
        $data['is_taxable'] = 1;
        $data['dates_requested'] = now();


        $create = OverTimeRequest::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Overtime application created successfully',
            'data' => $create
        ]);
    }

    public function UpdateOvertime(Request $request, string $id)
    {

        $data['over_time_type'] = $request->input('over_time_type');
        $data['requested_hours'] = $request->input('requested_hours');
        $data['justification'] = $request->input('justification');

        $updateLeave = OverTimeRequest::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Overtime application updated successfully',
            'data' => $updateLeave
        ]);
    }

    public function OvertimeDestroy(string $id)
    {
        $deleteLeave = OverTimeRequest::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Leave application deleted successfully',
        ]);
    }

    public function Accountupdate(Request $request)
    {

        $users = Auth::user()->id;
        $data['password'] = bcrypt($request->input('password'));
        $create = User::find($users)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'password updated successfully',
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

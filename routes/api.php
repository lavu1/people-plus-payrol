<?php


use App\Http\Controllers\Employee\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/get-access-token', [EmployeeController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    //getting services
    Route::get('/get-my-earnings', [EmployeeController::class, 'getEarnings']);
    Route::get('/get-my-advances', [EmployeeController::class, 'getAdvances']);
    Route::get('/leave-requests', [EmployeeController::class, 'getLeaveRequests']);
    Route::get('/leave-sales', [EmployeeController::class, 'leaveSales']);
    Route::get('/over-time-requests', [EmployeeController::class, 'OvertimeRequests']);
    Route::get('/payroll', [EmployeeController::class, 'Payroll']);
    //post data advance
    Route::post('/advance-application', [EmployeeController::class, 'AdvanceApplication']);
    Route::post('/edit-advance/{id}', [EmployeeController::class, 'UpdateAdvance']);
    Route::post('/delete-advance/{id}', [EmployeeController::class, 'Advancedestroy']);
    //leave
    Route::post('/leave-application', [EmployeeController::class, 'LeaveApplication']);
    Route::post('/edit-leave/{id}', [EmployeeController::class, 'UpdateLeave']);
    Route::post('/delete-leave/{id}', [EmployeeController::class, 'LeaveDestroy']);
    //leave sales
    Route::post('/leave-sale-application', [EmployeeController::class, 'LeaveSaleApplication']);
    Route::post('/edit-leave-sale/{id}', [EmployeeController::class, 'UpdateLeaveSale']);
    Route::post('/delete-leave-sale/{id}', [EmployeeController::class, 'LeaveSaleDestroy']);
    //account update

    Route::post('/update-account', [EmployeeController::class, 'Accountupdate']);
});




<?php

use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\ContractHistoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeHasAllowanceController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/employee', EmployeeController::class);
Route::apiResource('/allowance', AllowanceController::class);
Route::apiResource('/contract', ContractHistoryController::class);
Route::apiResource('/employee-has-allowance', EmployeeHasAllowanceController::class);
Route::apiResource('/payroll', PayrollController::class);

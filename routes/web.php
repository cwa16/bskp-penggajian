<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryGradeController;
use App\Http\Controllers\SalaryAnnualController;
use App\Http\Controllers\SalaryMonthlyController;
use App\Http\Controllers\SalaryRegularController;
use App\Http\Controllers\SalaryController;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index']);
Route::get('/employee', [EmployeeController::class, 'index']);
Route::get('/salarygrade', [SalaryGradeController::class, 'index']);
Route::get('/salaryannual', [SalaryAnnualController::class, 'index']);
Route::get('/salarymonthly', [SalaryMonthlyController::class, 'index']);
Route::get('/salaryregular', [SalaryRegularController::class, 'index']);
Route::get('/salary', [SalaryController::class, 'index']);

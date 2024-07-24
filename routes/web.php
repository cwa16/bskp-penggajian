<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalaryGradeController;
use App\Http\Controllers\SalaryYearController;
use App\Http\Controllers\SalaryMonthController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\WhatsAppController;

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('user', UserController::class);

// route edit tanpa parameter id, karena id nya menggunakan request
// Route::get('/salarygrade/edit', [SalaryGradeController::class, 'edit'])->name('salarygrade.edit');
// Route::put('/salarygrade/update', [SalaryGradeController::class, 'update'])->name('salarygrade.update_multiple');
// Route::get('/salary-year/edit', [SalaryYearController::class, 'edit'])->name('salary-year.edit');
// Route::put('/salary-year/update', [SalaryYearController::class, 'update'])->name('salary-year.update_multiple');
// Route::get('/salary-month/edit', [SalaryMonthController::class, 'edit'])->name('salary-month.edit');
// Route::put('/salary-month/update', [SalaryMonthController::class, 'update'])->name('salary-month.update_multiple');

// Route::resource('salary-year', SalaryYearController::class);
// Route::resource('salarygrade', SalaryGradeController::class);
// Route::resource('salary-month', SalaryMonthController::class);


Route::get('/salary-year', [SalaryYearController::class, 'index'])->name('salary-year');
Route::get('/salary-year/filter', [SalaryYearController::class, 'filter'])->name('salary-year.filter');
Route::get('/salary-year/create', [SalaryYearController::class, 'create'])->name('salary-year.create');
Route::post('/salary-year/store', [SalaryYearController::class, 'store'])->name('salary-year.store');
Route::get('/salary-year/edit', [SalaryYearController::class, 'edit'])->name('salary-year.edit');
Route::put('/salary-year/update', [SalaryYearController::class, 'update'])->name('salary-year.update');
Route::get('/salary-year/filter-new', [SalaryYearController::class, 'filter_new'])->name('salary-year.filter-new');
Route::get('/salary-year/get-emp', [SalaryYearController::class, 'get_emp'])->name('salary-year.get-emp');
Route::post('/salary-year/create-new', [SalaryYearController::class, 'create_new'])->name('salary-year.create-new');
Route::get('/salary-year/get-rate-salary', [SalaryYearController::class, 'get_rate_salary'])->name('salary-year.get-rate-salary');
Route::post('/salary-year/store-new', [SalaryYearController::class, 'store_new'])->name('salary-year.store-new');


Route::get('/salarygrade', [SalaryGradeController::class, 'index'])->name('salarygrade');
Route::get('/salarygrade/filter', [SalaryGradeController::class, 'filter'])->name('salarygrade.filter');
Route::get('/salarygrade/create', [SalaryGradeController::class, 'create'])->name('salarygrade.create');
Route::post('/salarygrade/store', [SalaryGradeController::class, 'store'])->name('salarygrade.store');
Route::get('/salarygrade/edit', [SalaryGradeController::class, 'edit'])->name('salarygrade.edit');
Route::put('/salarygrade/update', [SalaryGradeController::class, 'update'])->name('salarygrade.update');


Route::get('/salary-month', [SalaryMonthController::class, 'index'])->name('salary-month');
Route::get('/salary-month/filter', [SalaryMonthController::class, 'filter'])->name('salary-month.filter');
Route::get('/salary-month/create', [SalaryMonthController::class, 'create'])->name('salary-month.create');
Route::post('/salary-month/store', [SalaryMonthController::class, 'store'])->name('salary-month.store');
Route::get('/salary-month/edit', [SalaryMonthController::class, 'edit'])->name('salary-month.edit');
Route::put('/salary-month/update', [SalaryMonthController::class, 'update'])->name('salary-month.update');
Route::post('/salary-month/export', [SalaryMonthController::class, 'export'])->name('salary-month.export');
Route::post('/salary-month/import', [SalaryMonthController::class, 'import'])->name('salary-month.import');

Route::resource('salary', SalaryController::class);
Route::get('/summary', [SalaryController::class, 'summary'])->name('summary');
Route::get('/result', [SalaryController::class, 'result'])->name('result');
Route::resource('status', StatusController::class);
Route::resource('grade', GradeController::class);
Route::resource('departement', DeptController::class);
Route::resource('job', JobController::class);

Route::get('/print-pdf/{id}', [SalaryController::class, 'print']);
Route::get('/download-pdf/{id}', [SalaryController::class, 'download']);
Route::get('/print-all', [SalaryController::class, 'printall']);
Route::get('/print-allocation', [SalaryController::class, 'printallocation']);
Route::get('/pdf/{filename}', [SalaryController::class, 'show']);

Route::get('/send-whatsapp/{id}', [SalaryController::class, 'send'])->name('send-whatsapp');

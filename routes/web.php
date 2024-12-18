<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employees\employeesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees', [employeesController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [employeesController::class, 'create'])->name('employees.create');
Route::post('/employees', [employeesController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee_id}/edit', [employeesController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee_id}', [employeesController::class, 'update'])->name('employees.update');
Route::delete('/employees/{first_name}/{last_name}/{job_id}', [employeesController::class, 'destroy'])->name('employees.destroy');
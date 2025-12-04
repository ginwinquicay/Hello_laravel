<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\SupportStaffController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\StaffLoginController;

use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;

use App\Http\Controllers\SubmissionController;

Route::get('/', function() {return view('welcome');});

//Route::get('/test', function (){ return "Hello, this is from the route"; }) ;

//Route::get('test', [TestController::class, 'test']);

//Route::post('/test/get-user-input', [TestController::class, 'getInput']);

//Route::get('/users', [UserController::class, 'index']);

//

Route::get('/home', function(){
    return view('home');
});

Route::get('/test', function(){
    return view('testing/test');
});

//Customer Routes-----------------------------------------------------------------------------------------------------------------------------

//login
// Customer
Route::get('/login-customer', [CustomerLoginController::class, 'showLoginForm'])->name('login.customer');
Route::post('/login-customer', [CustomerLoginController::class, 'login']);
Route::get('/customer/dashboard', function () {
    return view('customer.dashboard');
})->middleware('auth:customer');
Route::get('/register-customer', [CustomerRegisterController::class, 'showRegisterForm'])->name('register.customer');
Route::post('/register-customer', [CustomerRegisterController::class, 'register']);
Route::get('/logout-customer', [App\Http\Controllers\Auth\CustomerLoginController::class, 'logout'])->name('logout.customer');

Route::middleware('auth:customer')->group(function () {
Route::get('/customer/feedback', [SubmissionController::class, 'create'])->name('customer.feedback');
Route::post('/customer/feedback', [SubmissionController::class, 'store'])->name('customer.feedback.submit');
});
Route::get('/customer/dashboard', [SubmissionController::class, 'customerDashboard'])->name('customer.dashboard');
Route::delete('/customer/submission/{id}', [SubmissionController::class, 'destroy'])->name('submission.destroy');
Route::get('/customer/submission/{id}/edit', [SubmissionController::class, 'edit'])->name('submission.edit');
Route::put('/customer/submission/{id}', [SubmissionController::class, 'update'])->name('submission.update');

// Staff
Route::get('/login-staff', [StaffLoginController::class, 'showLoginForm'])->name('login.staff');
Route::post('/login-staff', [StaffLoginController::class, 'login']);
Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->middleware('auth:staff');

Route::middleware('auth:staff')->group(function () {
    Route::get('/staff/dashboard', [SupportStaffController::class, 'dashboard'])
        ->name('staff.dashboard');
    Route::get('/staff/submission/{id}', [SupportStaffController::class, 'show'])
        ->name('staff.submission.show');
    Route::post('/staff/submission/{id}/assign', [SupportStaffController::class, 'assignToMe'])
        ->name('staff.submission.assign');
    Route::post('/staff/submission/{id}/status', [SupportStaffController::class, 'updateStatus'])
        ->name('staff.submission.status');
    Route::post('/staff/submission/{id}/comment', [SupportStaffController::class, 'addComment'])
        ->name('staff.submission.comment');
    Route::post('/staff/submission/{id}/delete', [SupportStaffController::class, 'delete'])
        ->name('staff.submission.delete');
    Route::get('/staff/reports', [SupportStaffController::class, 'reports'])
        ->name('staff.reports');
    Route::get('/staff/reports/export-unresolved', [SupportStaffController::class, 'exportUnresolvedCsv'])
        ->name('staff.reports.export.unresolved');
});





// Admin
Route::get('/login-admin', [AdminLoginController::class, 'showLoginForm'])->name('login.admin');
Route::post('/login-admin', [AdminLoginController::class, 'login']);
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth:admin');

// Logout for each user type

Route::get('/logout-staff', [App\Http\Controllers\Auth\StaffLoginController::class, 'logout'])->name('logout.staff');
Route::post('/logout-admin', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout.admin');

// Customer Registration


//Submission



//Staff routes--------------------------------------------------------------------------------------------------------------------------------

/*
| Staff auth routes
*/
    // sample to create a user quickly (remove for production)
    // Route::get('create-sample-staff', [StaffAuthController::class, 'createSampleStaff']);


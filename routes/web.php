<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\SupportStaffController;
use App\Http\Controllers\SystemAdminController;
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

Route::get('/home', function () {return view('home');})->name('home');

//Customer Routes

// Customer Login
Route::get('/login-customer', [CustomerLoginController::class, 'showLoginForm'])->name('login.customer');
Route::post('/login-customer', [CustomerLoginController::class, 'login']);
Route::get('/customer/dashboard', function () {
    return view('customer.dashboard');
})->middleware('auth:customer');

//Customer registration
Route::get('/register-customer', [CustomerRegisterController::class, 'showRegisterForm'])->name('register.customer');
Route::post('/register-customer', [CustomerRegisterController::class, 'register']);

Route::middleware('auth:customer')->group(function () {
Route::get('/customer/feedback', [SubmissionController::class, 'create'])->name('customer.feedback');
Route::post('/customer/feedback', [SubmissionController::class, 'store'])->name('customer.feedback.submit');
});
//Feedback Submission and Management
Route::get('/customer/dashboard', [SubmissionController::class, 'customerDashboard'])->name('customer.dashboard');
Route::delete('/customer/submission/{id}', [SubmissionController::class, 'destroy'])->name('submission.destroy');
Route::get('/customer/submission/{id}/edit', [SubmissionController::class, 'edit'])->name('submission.edit');
Route::put('/customer/submission/{id}', [SubmissionController::class, 'update'])->name('submission.update');

//Customer Logout
Route::get('/logout-customer', [CustomerLoginController::class, 'logout'])->name('logout.customer');

// Staff Login
Route::get('/login-staff', [StaffLoginController::class, 'showLoginForm'])->name('login.staff');
Route::post('/login-staff', [StaffLoginController::class, 'login']);
Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->middleware('auth:staff');

//Staff Submission management
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
Route::delete('/staff/submission/{id}/delete', [SupportStaffController::class, 'delete'])
        ->name('staff.submission.delete');
Route::get('/staff/reports', [SupportStaffController::class, 'reports'])
        ->name('staff.reports');
Route::get('/staff/reports/export-unresolved', [SupportStaffController::class, 'exportReportCsv'])
        ->name('staff.reports.export.unresolved');
Route::post('/staff/submission/{id}/close',[SupportStaffController::class, 'close'])
        ->name('staff.submission.close');
});
//Staff Logout
Route::get('/logout-staff', [StaffLoginController::class, 'logout'])->name('logout.staff');

// Admin Login
Route::get('/login-admin', [AdminLoginController::class, 'showLoginForm'])->name('login.admin');
Route::post('/login-admin', [AdminLoginController::class, 'login']);

// Admin routes protected by auth:admin
Route::middleware('auth:admin')->group(function () {

// Admin Dashboard
Route::get('/admin/dashboard', [SystemAdminController::class, 'dashboard'])->name('admin.dashboard');

// Customer management
Route::get('/admin/customers', [SystemAdminController::class, 'listCustomers'])
    ->name('admin.customers');
Route::get('/admin/customers/create', [SystemAdminController::class, 'createCustomer'])
    ->name('admin.customers.create');
Route::post('/admin/customers/store', [SystemAdminController::class, 'storeCustomer'])
    ->name('admin.customers.store');
Route::get('/admin/customers/{id}/edit', [SystemAdminController::class, 'editCustomer'])
    ->name('admin.customers.edit');
Route::put('/admin/customers/{id}', [SystemAdminController::class, 'updateCustomer'])
    ->name('admin.customers.update');
Route::delete('/admin/customers/{id}', [SystemAdminController::class, 'deleteCustomer'])
    ->name('admin.customers.delete');

// Staff management
Route::get('/admin/staff', [SystemAdminController::class, 'listStaff'])
    ->name('admin.staff');
Route::get('/admin/staff/create', [SystemAdminController::class, 'createStaff'])
    ->name('admin.staff.create');
Route::post('/admin/staff/store', [SystemAdminController::class, 'storeStaff'])
    ->name('admin.staff.store');
Route::get('/admin/staff/{id}/edit', [SystemAdminController::class, 'editStaff'])
    ->name('admin.staff.edit');
Route::put('/admin/staff/{id}', [SystemAdminController::class, 'updateStaff'])
    ->name('admin.staff.update');
Route::delete('/admin/staff/{id}', [SystemAdminController::class, 'deleteStaff'])
    ->name('admin.staff.delete');

// Submission categories & priorities
Route::get('/admin/categories', [SystemAdminController::class, 'listCategories'])
    ->name('admin.categories');
Route::get('/admin/categories/create', [SystemAdminController::class, 'createCategory'])
    ->name('admin.categories.create');
Route::post('/admin/categories/store', [SystemAdminController::class, 'storeCategory'])
    ->name('admin.categories.store');
Route::get('/admin/categories/{id}/edit', [SystemAdminController::class, 'editCategory'])
    ->name('admin.categories.edit');
Route::put('/admin/categories/{id}', [SystemAdminController::class, 'updateCategory'])
    ->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [SystemAdminController::class, 'deleteCategory'])
    ->name('admin.categories.delete');

Route::get('/admin/priorities', [SystemAdminController::class, 'listPriorities'])
    ->name('admin.priorities');
Route::get('/admin/priorities/create', [SystemAdminController::class, 'createPriority'])
    ->name('admin.priorities.create');
Route::post('/admin/priorities/store', [SystemAdminController::class, 'storePriority'])
    ->name('admin.priorities.store');
Route::get('/admin/priorities/{id}/edit', [SystemAdminController::class, 'editPriority'])
    ->name('admin.priorities.edit');
Route::put('/admin/priorities/{id}', [SystemAdminController::class, 'updatePriority'])
    ->name('admin.priorities.update');
Route::delete('/admin/priorities/{id}', [SystemAdminController::class, 'deletePriority'])
    ->name('admin.priorities.delete');

// Submissions management (delete test/invalid)
Route::get('admin/submissions', [SystemAdminController::class, 'listDeletedSubmissions'])
    ->name('admin.submissions');
Route::post('admin/submissions/{id}/restore', [SystemAdminController::class, 'restoreSubmission'])
    ->name('admin.submissions.restore');
Route::delete('admin/submissions/{id}/force-delete', [SystemAdminController::class, 'forceDeleteSubmission'])
    ->name('admin.submissions.forceDelete');

// Logout
Route::get('/logout-admin', [AdminLoginController::class, 'logout'])->name('logout.admin');
});

//testing push
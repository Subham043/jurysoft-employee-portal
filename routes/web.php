<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\User\UserPictureController;
use App\Http\Controllers\Admin\Department\DepartmentController;
use App\Http\Controllers\Admin\Designation\DesignationController;
use App\Http\Controllers\Admin\Division\DivisionController;
use App\Http\Controllers\Admin\EmployeeType\EmployeeTypeController;
use App\Http\Controllers\Admin\ExitMode\ExitModeController;
use App\Http\Controllers\Admin\CtcFixedItem\CtcFixedItemController;
use App\Http\Controllers\Admin\Payslip\PayslipController;

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

Route::middleware(['guest'])->group(function () {

    Route::prefix('/')->group(function () {
        Route::get('/', [LoginController::class, 'index', 'as' => 'admin.login'])->name('login');
        Route::post('/authenticate', [LoginController::class, 'authenticate', 'as' => 'admin.authenticate'])->name('authenticate');
        Route::get('/forgot-password', [ForgotPasswordController::class, 'index', 'as' => 'admin.forgot_password'])->name('forgotPassword');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'requestForgotPassword', 'as' => 'admin.requestForgotPassword'])->name('requestForgotPassword');
        Route::get('/reset-password/{id}', [ResetPasswordController::class, 'index', 'as' => 'admin.reset_password'])->name('reset_password');
        Route::post('/reset-password/{id}', [ResetPasswordController::class, 'requestResetPassword', 'as' => 'admin.requestResetPassword'])->name('requestResetPassword');
    });

});

Route::prefix('/')->middleware(['auth', 'admin', 'blocked'])->group(function () {

    Route::prefix('/employee')->group(function () {
        Route::get('/', [UserController::class, 'view', 'as' => 'admin.subadmin.view'])->name('subadmin_view');
        Route::get('/view/{id}', [UserController::class, 'display', 'as' => 'admin.subadmin.display'])->name('subadmin_display');
        Route::get('/create', [UserController::class, 'create', 'as' => 'admin.subadmin.create'])->name('subadmin_create');
        Route::post('/create', [UserController::class, 'store', 'as' => 'admin.subadmin.store'])->name('subadmin_store');
        Route::post('/get-user-json', [UserController::class, 'json', 'as' => 'admin.subadmin.json'])->name('subadmin_json');
        Route::get('/excel', [UserController::class, 'excel', 'as' => 'admin.subadmin.excel'])->name('subadmin_excel');
        Route::get('/edit/{id}', [UserController::class, 'edit', 'as' => 'admin.subadmin.edit'])->name('subadmin_edit');
        Route::post('/edit/{id}', [UserController::class, 'update', 'as' => 'admin.subadmin.update'])->name('subadmin_update');
        Route::get('/delete/{id}', [UserController::class, 'delete', 'as' => 'admin.subadmin.delete'])->name('subadmin_delete');

        Route::prefix('/picture')->group(function () {
            Route::get('/{employee_id}', [UserPictureController::class, 'picture_display', 'as' => 'admin.subadmin.picture_display'])->name('subadmin_picture_display');
            Route::post('/{employee_id}', [UserPictureController::class, 'picture_save', 'as' => 'admin.subadmin.picture_save'])->name('subadmin_picture_save');
        });
    });

    Route::prefix('/department')->group(function () {
        Route::get('/', [DepartmentController::class, 'view', 'as' => 'admin.department.view'])->name('department_view');
        Route::get('/view/{id}', [DepartmentController::class, 'display', 'as' => 'admin.department.display'])->name('department_display');
        Route::get('/create', [DepartmentController::class, 'create', 'as' => 'admin.department.create'])->name('department_create');
        Route::post('/create', [DepartmentController::class, 'store', 'as' => 'admin.department.store'])->name('department_store');
        Route::get('/excel', [DepartmentController::class, 'excel', 'as' => 'admin.department.excel'])->name('department_excel');
        Route::get('/edit/{id}', [DepartmentController::class, 'edit', 'as' => 'admin.department.edit'])->name('department_edit');
        Route::post('/edit/{id}', [DepartmentController::class, 'update', 'as' => 'admin.department.update'])->name('department_update');
        Route::get('/delete/{id}', [DepartmentController::class, 'delete', 'as' => 'admin.department.delete'])->name('department_delete');
    });
    
    Route::prefix('/designation')->group(function () {
        Route::get('/', [DesignationController::class, 'view', 'as' => 'admin.designation.view'])->name('designation_view');
        Route::get('/view/{id}', [DesignationController::class, 'display', 'as' => 'admin.designation.display'])->name('designation_display');
        Route::get('/create', [DesignationController::class, 'create', 'as' => 'admin.designation.create'])->name('designation_create');
        Route::post('/create', [DesignationController::class, 'store', 'as' => 'admin.designation.store'])->name('designation_store');
        Route::get('/excel', [DesignationController::class, 'excel', 'as' => 'admin.designation.excel'])->name('designation_excel');
        Route::get('/edit/{id}', [DesignationController::class, 'edit', 'as' => 'admin.designation.edit'])->name('designation_edit');
        Route::post('/edit/{id}', [DesignationController::class, 'update', 'as' => 'admin.designation.update'])->name('designation_update');
        Route::get('/delete/{id}', [DesignationController::class, 'delete', 'as' => 'admin.designation.delete'])->name('designation_delete');
    });
    
    Route::prefix('/division')->group(function () {
        Route::get('/', [DivisionController::class, 'view', 'as' => 'admin.division.view'])->name('division_view');
        Route::get('/view/{id}', [DivisionController::class, 'display', 'as' => 'admin.division.display'])->name('division_display');
        Route::get('/create', [DivisionController::class, 'create', 'as' => 'admin.division.create'])->name('division_create');
        Route::post('/create', [DivisionController::class, 'store', 'as' => 'admin.division.store'])->name('division_store');
        Route::get('/excel', [DivisionController::class, 'excel', 'as' => 'admin.division.excel'])->name('division_excel');
        Route::get('/edit/{id}', [DivisionController::class, 'edit', 'as' => 'admin.division.edit'])->name('division_edit');
        Route::post('/edit/{id}', [DivisionController::class, 'update', 'as' => 'admin.division.update'])->name('division_update');
        Route::get('/delete/{id}', [DivisionController::class, 'delete', 'as' => 'admin.division.delete'])->name('division_delete');
    });
    
    Route::prefix('/ctc')->group(function () {
        Route::get('/medical-allowance', [CtcFixedItemController::class, 'medical_allowance_create', 'as' => 'admin.ctc.medical_allowance_create'])->name('medical_allowance_create');
        Route::post('/medical-allowance-save', [CtcFixedItemController::class, 'medical_allowance_store', 'as' => 'admin.ctc.medical_allowance_store'])->name('medical_allowance_store');
        Route::get('/conveyance-allowance', [CtcFixedItemController::class, 'conveyance_allowance_create', 'as' => 'admin.ctc.conveyance_allowance_create'])->name('conveyance_allowance_create');
        Route::post('/conveyance-allowance-save', [CtcFixedItemController::class, 'conveyance_allowance_store', 'as' => 'admin.ctc.conveyance_allowance_store'])->name('conveyance_allowance_store');
        Route::get('/professional-tax', [CtcFixedItemController::class, 'professional_tax_create', 'as' => 'admin.ctc.professional_tax_create'])->name('professional_tax_create');
        Route::post('/professional-tax-save', [CtcFixedItemController::class, 'professional_tax_store', 'as' => 'admin.ctc.professional_tax_store'])->name('professional_tax_store');
    });
    
    Route::prefix('/employee-type')->group(function () {
        Route::get('/', [EmployeeTypeController::class, 'view', 'as' => 'admin.employee_type.view'])->name('employee_type_view');
        Route::get('/view/{id}', [EmployeeTypeController::class, 'display', 'as' => 'admin.employee_type.display'])->name('employee_type_display');
        Route::get('/create', [EmployeeTypeController::class, 'create', 'as' => 'admin.employee_type.create'])->name('employee_type_create');
        Route::post('/create', [EmployeeTypeController::class, 'store', 'as' => 'admin.employee_type.store'])->name('employee_type_store');
        Route::get('/excel', [EmployeeTypeController::class, 'excel', 'as' => 'admin.employee_type.excel'])->name('employee_type_excel');
        Route::get('/edit/{id}', [EmployeeTypeController::class, 'edit', 'as' => 'admin.employee_type.edit'])->name('employee_type_edit');
        Route::post('/edit/{id}', [EmployeeTypeController::class, 'update', 'as' => 'admin.employee_type.update'])->name('employee_type_update');
        Route::get('/delete/{id}', [EmployeeTypeController::class, 'delete', 'as' => 'admin.employee_type.delete'])->name('employee_type_delete');
    });
    
    Route::prefix('/mode-of-exit')->group(function () {
        Route::get('/', [ExitModeController::class, 'view', 'as' => 'admin.exit_mode.view'])->name('exit_mode_view');
        Route::get('/view/{id}', [ExitModeController::class, 'display', 'as' => 'admin.exit_mode.display'])->name('exit_mode_display');
        Route::get('/create', [ExitModeController::class, 'create', 'as' => 'admin.exit_mode.create'])->name('exit_mode_create');
        Route::post('/create', [ExitModeController::class, 'store', 'as' => 'admin.exit_mode.store'])->name('exit_mode_store');
        Route::get('/excel', [ExitModeController::class, 'excel', 'as' => 'admin.exit_mode.excel'])->name('exit_mode_excel');
        Route::get('/edit/{id}', [ExitModeController::class, 'edit', 'as' => 'admin.exit_mode.edit'])->name('exit_mode_edit');
        Route::post('/edit/{id}', [ExitModeController::class, 'update', 'as' => 'admin.exit_mode.update'])->name('exit_mode_update');
        Route::get('/delete/{id}', [ExitModeController::class, 'delete', 'as' => 'admin.exit_mode.delete'])->name('exit_mode_delete');
    });
    
    Route::prefix('/payslip')->group(function () {
        Route::get('/', [PayslipController::class, 'view', 'as' => 'admin.payslip.view'])->name('payslip_view');
        Route::get('/view/{id}', [PayslipController::class, 'display', 'as' => 'admin.payslip.display'])->name('payslip_display');
        Route::get('/create', [PayslipController::class, 'create', 'as' => 'admin.payslip.create'])->name('payslip_create');
        Route::post('/create', [PayslipController::class, 'store', 'as' => 'admin.payslip.store'])->name('payslip_store');
        Route::get('/excel', [PayslipController::class, 'excel', 'as' => 'admin.payslip.excel'])->name('payslip_excel');
        Route::get('/edit/{id}', [PayslipController::class, 'edit', 'as' => 'admin.payslip.edit'])->name('payslip_edit');
        Route::post('/edit/{id}', [PayslipController::class, 'update', 'as' => 'admin.payslip.update'])->name('payslip_update');
        Route::get('/delete/{id}', [PayslipController::class, 'delete', 'as' => 'admin.payslip.delete'])->name('payslip_delete');
    });

});

Route::prefix('/')->middleware(['auth', 'blocked'])->group(function () {
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index', 'as' => 'admin.profile'])->name('profile');
        Route::post('/update', [ProfileController::class, 'update', 'as' => 'admin.profile_update'])->name('profile_update');
        Route::post('/profile-password-update', [ProfileController::class, 'profile_password', 'as' => 'admin.profile_password'])->name('profile_password_update');
    });

    Route::prefix('/payslip-detail')->group(function () {
        Route::get('/', [PayslipController::class, 'view_user', 'as' => 'admin.payslip.view_user'])->name('payslip_view_user');
        Route::get('/view/{id}', [PayslipController::class, 'display_user', 'as' => 'admin.payslip.display_user'])->name('payslip_display_user');
    });

    Route::get('/employee-detail', [UserController::class, 'detail', 'as' => 'admin.subadmin.detail'])->name('subadmin_detail');

    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'admin.dashboard'])->name('dashboard');
    Route::get('/logout', [LogoutController::class, 'logout', 'as' => 'admin.logout'])->name('logout');
});

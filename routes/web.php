<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CorrespondenceManagement\InboxController;
use App\Http\Controllers\OutgoingDocumentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Roles Management
    |--------------------------------------------------------------------------
    */
    Route::resource('roles', RoleController::class);

    /*
    |--------------------------------------------------------------------------
    | Users Management
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | Tasks
    |--------------------------------------------------------------------------
    */
    Route::get('/tasks/charts', [TaskController::class, 'charts'])->name('tasks.charts');
    Route::patch('/tasks/{task}/change-status', [TaskController::class, 'changeStatus'])->name('tasks.changeStatus');
    Route::get('/tasks/{task}/monitoring', [TaskController::class, 'monitoring'])->name('tasks.monitoring');
    Route::resource('tasks', TaskController::class);

    /*
    |--------------------------------------------------------------------------
    | Employees
    |--------------------------------------------------------------------------
    */
    Route::get('/employees/{employee}/monitoring', [EmployeeController::class, 'monitoring'])->name('employees.monitoring');
    Route::patch('/employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggleStatus');
    Route::get('/employees/export/excel', [EmployeeController::class, 'exportExcel'])->name('employees.export.excel');
    Route::get('/employees/export/pdf', [EmployeeController::class, 'exportPdf'])->name('employees.export.pdf');
    Route::resource('employees', EmployeeController::class);

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    /*
    |--------------------------------------------------------------------------
    | Inbox / Correspondence
    |--------------------------------------------------------------------------
    */
    Route::resource('inbox', InboxController::class);
    Route::get('CorrespondenceManagement/inbox/index', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('CorrespondenceManagement/inbox/create', [InboxController::class, 'create'])->name('inbox.create');
       Route::get('CorrespondenceManagement/inbox/form', [InboxController::class, 'form'])->name('inbox.form');
    Route::get('CorrespondenceManagement/main', [InboxController::class, 'main'])->name('main');

    Route::post('CorrespondenceManagement/inbox/store', [InboxController::class, 'store'])->name('inbox.store');
    Route::get('CorrespondenceManagement/inbox/{id}', [InboxController::class, 'show'])->name('inbox.show');
    Route::get('CorrespondenceManagement/inbox/{id}/edit', [InboxController::class, 'edit'])->name('inbox.edit');
    Route::put('CorrespondenceManagement/inbox/{id}', [InboxController::class, 'update'])->name('inbox.update');
    Route::delete('CorrespondenceManagement/inbox/{id}', [InboxController::class, 'destroy'])->name('inbox.destroy');
    

    /*
    |--------------------------------------------------------------------------
    | Outbox
    |--------------------------------------------------------------------------
    */
    Route::get('CorrespondenceManagement/outbox/create', [OutgoingDocumentController::class, 'create'])->name('CorrespondenceManagement.outbox.create');
    Route::post('CorrespondenceManagement/outbox/store', [OutgoingDocumentController::class, 'store'])->name('CorrespondenceManagement.outbox.store');
    Route::get('CorrespondenceManagement/outbox/index', [OutgoingDocumentController::class, 'index'])->name('CorrespondenceManagement.outbox.index');
    Route::get('CorrespondenceManagement/outbox/{id}', [OutgoingDocumentController::class, 'show'])->name('CorrespondenceManagement.outbox.show');
    Route::get('CorrespondenceManagement/outbox/{id}/edit', [OutgoingDocumentController::class, 'edit'])->name('CorrespondenceManagement.outbox.edit');
    Route::put('CorrespondenceManagement/outbox/{id}', [OutgoingDocumentController::class, 'update'])->name('CorrespondenceManagement.outbox.update');
    Route::delete('CorrespondenceManagement/outbox/{id}', [OutgoingDocumentController::class, 'destroy'])->name('CorrespondenceManagement.outbox.destroy');


 /*
    |--------------------------------------------------------------------------
    | Administration 
    |--------------------------------------------------------------------------
    */
      Route::get('/administrations/users/create', [UserController::class, 'create'])->name('Administrations.create');
      Route::get('/administrations/roles', [RoleController::class, 'index'])->name('Administrations.Roles');
      Route::get('/administrations/role-management', [RoleController::class, 'index'])->name('Administrations.Role Management');
      Route::get('/administrations/user-management', [UserController::class, 'index'])->name('Administrations.User Management');
    /*
    |--------------------------------------------------------------------------
    | Documents
    |--------------------------------------------------------------------------
    */
    Route::resource('documents', DocumentController::class);
    Route::get('/Document Management/Search', [DocumentController::class, 'search'])->name('documents.search');
    Route::get('/Document Management/Search & Filter', [DocumentController::class, 'Search & Filter'])->name('documents.Search & Filter');
     /*
    |--------------------------------------------------------------------------
    | ADmin
    |--------------------------------------------------------------------------
    */
      Route::resource('admin', UserController::class);
    Route::get('/admin/settings', [UserController::class, 'settings'])->name('admin.settings');

       /*
    |--------------------------------------------------------------------------
    | Languages
    |--------------------------------------------------------------------------
    */  
     route::get('lang/ps',function (){
     return view('lang.ps');
     })->name('lang.ps'); 


     route::get('lang/fa',function (){
     return view('lang.fa');
     })->name('lang.fa');

     /*
    |--------------------------------------------------------------------------
    | Clock
    |--------------------------------------------------------------------------
    */  

      Route::get('clock', function () {
      return view('clock');
      })->name('clock');

  });
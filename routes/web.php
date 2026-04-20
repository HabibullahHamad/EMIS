<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CorrespondenceManagement\InboxController;
use App\Http\Controllers\OutgoingDocumentController;
use App\Http\Controllers\SettingsController;

use App\Http\Middleware\SetLocale;
use App\Http\Controllers\AdminSettingsController;


/*
|--------------------------------------------------------------------------
| settings Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/settings', [AdminSettingsController::class, 'index'])->name('admin.settings');
    Route::put('/admin/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware([SetLocale::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // other routes...
});
Route::post('/language-switch', function (Request $request) {
    $request->validate([
        'locale' => 'required|in:en,ps,fa',
    ]);

    session(['locale' => $request->locale]);

    return back();
})->name('language.switch');
    // all My  EMIS routes here
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
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');   
   /*
    |--------------------------------------------------------------------------
    | settings
    |--------------------------------------------------------------------------
    */

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

        /*
    |--------------------------------------------------------------------------
    | lANG
    |--------------------------------------------------------------------------
    */ 
   

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ps', 'fa'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/lang/en', function () {
    Session::put('locale', 'en');
    return redirect()->back();
})->name('lang.en');

Route::get('/lang/ps', function () {
    Session::put('locale', 'ps');
    return redirect()->back();
})->name('lang.ps');

Route::get('/lang/fa', function () {
    Session::put('locale', 'fa');
    return redirect()->back();
})->name('lang.fa');
  });

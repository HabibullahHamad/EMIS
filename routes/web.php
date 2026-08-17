<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\FocalPointController;
use App\Http\Controllers\BudgetEntityController;
use App\Http\Controllers\FocalPointIntroductionController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
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

use App\Http\Middleware\SetLocale;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\DepartmentReportController;

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\AuditLogController;
use app\http\controllers\logoutcontroller;

use App\Http\Controllers\TrackingController;






// tracking routes 

Route::middleware(['auth'])->group(function () {
    Route::get('/tracking', [TrackingController::class, 'index'])
        ->name('tracking.index');
});

// protect routes with auth middleware
Route::middleware(['auth'])->group(function () {

    Route::resource('users', UserController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('inbox', InboxController::class);
Route::resource('outbox', OutgoingDocumentController::class);    



    Route::resource('workflows', WorkflowController::class);

});


// documents 
Route::resource('documents', DocumentController::class);
Route::get('/documents/report/export', [DocumentController::class, 'exportReport'])
    ->name('documents.report');
    

    Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');


Route::get('/documents/{id}/pdf', [DocumentController::class, 'exportPdf'])
    ->name('documents.pdf');
Route::post('/documents/{id}/assign', [DocumentController::class, 'assign'])->name('documents.assign');
Route::post('/documents/{id}/respond', [DocumentController::class, 'respond'])->name('documents.respond');
Route::post('/documents/{id}/complete', [DocumentController::class, 'complete'])->name('documents.complete');
Route::get('/documents/{id}/view', [DocumentController::class, 'view'])->name('documents.view');
// end 
/*
|--------------------------------------------------------------------------
| // Notification routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');

    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');
});
// end//  Notifications Routes /////////////////////////////

// for audit logs export /////////////////////////////
Route::patch('/users/{user}/block', [UserController::class, 'block'])
    ->name('users.block')
    ->middleware('auth');

Route::patch('/users/{user}/unblock', [UserController::class, 'unblock'])
    ->name('users.unblock')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| // Auditlogs routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('/audit-logs/export/pdf', [AuditLogController::class, 'exportPdf'])->name('audit.export.pdf');
    Route::get('/audit-logs/export/excel', [AuditLogController::class, 'exportExcel'])->name('audit.export.excel');
    Route::get('/audit-logs/export/csv', [AuditLogController::class, 'exportCsv'])->name('audit.export.csv');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit.show');
});

/*
|--------------------------------------------------------------------------
| // Workflow routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('workflows')->name('workflows.')->group(function () {
    Route::get('/', [WorkflowController::class, 'index'])->name('index');
    Route::get('/create', [WorkflowController::class, 'create'])->name('create');
    Route::post('/', [WorkflowController::class, 'store'])->name('store');

    Route::get('/pending', [WorkflowController::class, 'pending'])->name('pending');
    Route::get('/sent', [WorkflowController::class, 'sent'])->name('sent');

    Route::get('/{workflow}', [WorkflowController::class, 'show'])->name('show');

    Route::post('/{workflow}/approve', [WorkflowController::class, 'approve'])->name('approve');
    Route::post('/{workflow}/reject', [WorkflowController::class, 'reject'])->name('reject');
    Route::post('/{workflow}/return', [WorkflowController::class, 'returnBack'])->name('return');
    Route::post('/{workflow}/complete', [WorkflowController::class, 'complete'])->name('complete');
});
/*
|--------------------------------------------------------------------------
| Department Routes
|--------------------------------------------------------------------------
*/


Route::get('/department-reports', [DepartmentReportController::class, 'index'])->name('department.reports.index');
Route::post('/department-reports/preview', [DepartmentReportController::class, 'preview'])->name('department.reports.preview');
Route::post('/department-reports/export-pdf', [DepartmentReportController::class, 'exportPdf'])->name('department.reports.exportPdf');


Route::middleware(['auth'])->group(function () {
    Route::resource('departments', DepartmentController::class);
});
Route::get('/departments-print', [DepartmentController::class, 'print'])
    ->name('departments.print');
/*
|--------------------------------------------------------------------------
| settings Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware([SetLocale::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // other routes...
});

// languages 


/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
*/

Route::post('/language-switch', function (Request $request) {
    $validated = $request->validate([
        'locale' => [
            'required',
            'string',
            'in:en,ps,fa',
        ],
    ]);

    $request->session()->put(
        'locale',
        $validated['locale']
    );

    return redirect()->back();
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

/* Public QR verification; no login is required. */
Route::get(
    '/focal-point-cards/verify/{uuid}',
    [FocalPointController::class, 'verifyCard']
)->name('focal-point-cards.verify');

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

// CUSTOM ROUTES FIRST
        Route::get('/tasks/charts', [TaskController::class, 'charts'])->name('tasks.charts');
        Route::get('/tasks/status/{status}', [TaskController::class, 'status'])->name('tasks.status');
        Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
        Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');
        Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
  route::get('/tasks/export/excel', [TaskController::class, 'exportExcel'])->name('tasks.export.excel');
        Route::get('/tasks/export/pdf', [TaskController::class, 'exportPdf'])->name('tasks.export.pdf');
        route::get('/tasks/export/csv', [TaskController::class, 'exportCsv'])->name('tasks.export.csv');

       route::patch('/tasks/{task}/change-status', [TaskController::class, 'changeStatus'])->name('tasks.changeStatus');
         

   route::get('/tasks/{task}/monitoring', [TaskController::class, 'monitoring'])->name('tasks.monitoring');


        Route::resource('tasks', TaskController::class);
// RESOURCE LAST


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
   


//   multiple attachs
Route::get(

'/inbox/{inbox}/combine-pdf',

[InboxController::class,

'combinePdf']

)

->name(

'inbox.combinePdf'

);

Route::get(

'/outbox/{outbox}/combine-pdf',

[OutgoingDocumentController::class,

'combinePdf']

)

->name(

'outbox.combinePdf'

);


// route for Focal point 

/*
|--------------------------------------------------------------------------
| Focal Point Registration and Card Management
|--------------------------------------------------------------------------
|
| The public verification route stays outside the auth group.
| All administrative routes require authentication.
|
*/

    /*
    |--------------------------------------------------------------------------
    | Single registration/card-management page
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/focal-point-registration/{focalPoint?}',
        [FocalPointController::class, 'registration']
    )->name('focal-points.registration');

    /*
    |--------------------------------------------------------------------------
    | Focal-point CRUD
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'focal-points',
        FocalPointController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Focal-point status actions
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/focal-points/{focalPoint}/approve',
        [FocalPointController::class, 'approve']
    )->name('focal-points.approve');

    Route::post(
        '/focal-points/{focalPoint}/suspend',
        [FocalPointController::class, 'suspend']
    )->name('focal-points.suspend');

    /*
    |--------------------------------------------------------------------------
    | Card generation, renewal and replacement
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/focal-points/{focalPoint}/cards/generate',
        [FocalPointController::class, 'generateCard']
    )->name('focal-points.cards.generate');

    /*
    |--------------------------------------------------------------------------
    | Card actions
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/focal-point-cards/{card}',
        [FocalPointController::class, 'showCard']
    )->name('focal-point-cards.show');

    Route::get(
        '/focal-point-cards/{card}/print',
        [FocalPointController::class, 'printCard']
    )->name('focal-point-cards.print');

    Route::post(
        '/focal-point-cards/{card}/mark-printed',
        [FocalPointController::class, 'markPrinted']
    )->name('focal-point-cards.mark-printed');

    Route::post(
        '/focal-point-cards/{card}/issue',
        [FocalPointController::class, 'issueCard']
    )->name('focal-point-cards.issue');

    Route::post(
        '/focal-point-cards/{card}/revoke',
        [FocalPointController::class, 'revokeCard']
    )->name('focal-point-cards.revoke');

    /*
    |--------------------------------------------------------------------------
    | Budget entity and introduction letter
    |--------------------------------------------------------------------------
    */

    // Add a budget entity for a focal point



Route::middleware('auth')->group(function (): void {
    Route::resource(
        'budget-entities',
        BudgetEntityController::class
    );

    Route::patch(
        '/focal-point-introductions/{focalPointIntroduction}/status',
        [
            FocalPointIntroductionController::class,
            'updateStatus',
        ]
    )->name('focal-point-introductions.status');

    Route::get(
        '/focal-point-introductions/{focalPointIntroduction}/attachment',
        [
            FocalPointIntroductionController::class,
            'downloadAttachment',
        ]
    )->name('focal-point-introductions.attachment');

       Route::resource(
        'focal-point-introductions',
        FocalPointIntroductionController::class
    );
});

/*
|--------------------------------------------------------------------------
| Close the main authenticated routes group opened at line 234
|--------------------------------------------------------------------------
*/

});

require __DIR__.'/settings.php';

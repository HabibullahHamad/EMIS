<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorrespondenceManagement\InboxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CorrespondenceManagement\LetterController;
use App\Http\Controllers\CorrespondenceManagement\OutgoingController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('new');
});


// WEB ROUTES for inbox module//
Route::get('/CorrespondenceManagement/inbox/inbox', function () {
    return view ('CorrespondenceManagement.inbox.inbox');
});

Route::get('/CorrespondenceManagement/inbox/index', function () {
    return view ('CorrespondenceManagement.inbox.index');
});
// WEB ROUTES//end of inbox

Route::get('/dashboard', function () {
    return view('Layout.dashboard');
})->name('dashboard');


// Route::get('/new', function () {
//     return view('Layout.new');
// })->name('new');


route::get('/Administrations/User Management', [UserController::class, 'index'])->name('Administrations.User Management');
Route::resource('inbox', InboxController::class);

//USER MANAGEMENT//
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::post('Administrations/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::get('admin/users/create', [UserController::class, 'create'])->name('Administrations.create');


route::post('/Administrations/store', [UserController::class, 'store'])->name('Administrations.store');

route::get('/Administrations/edit/{user}', [UserController::class, 'edit'])->name('Administrations.edit');

// END USER MAN//
// routes/web.php
Route::get('/login', function () {
    return 'Login page placeholder';
})->name('login');

// Additional routes can be added below as needed






Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});





Route::get('CorrespondenceManagement/inbox/index', [InboxController::class, 'index'])
    ->name('inbox.index');






Route::get('CorrespondenceManagement/inbox/create', function () {
    return view('create');
});


route::get('CorrespondenceManagement/inbox/form', function(){
    return view('form');
});





route::get('CorrespondenceManagement/inbox/create', [InboxController::class, 'create'])->name('inbox.create');




Route::get('/inbox/create', [InboxController::class, 'create'])->name('inbox.create');
Route::post('/inbox/create', [InboxController::class, 'store'])->name('inbox.store');
Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
route::get('/inbox/{id}', [InboxController::class, 'show'])->name('inbox.show');
route::get('/inbox/{id}/edit', [InboxController::class, 'edit'])->name('inbox.edit');
route::put('/inbox/{id}', [InboxController::class, 'update'])->name('inbox.update');

route::post('CorrespondenceManagement/inbox/store', [InboxController::class, 'store'])->name('inbox.store');
route::get('CorrespondenceManagement/inbox/index', [InboxController::class, 'index'])->name('inbox.index'); 
route::get('CorrespondenceManagement/inbox/{id}/edit', [InboxController::class, 'edit'])->name('inbox.edit'); 
route::get('CorrespondenceManagement/inbox/{id}', [InboxController::class, 'show'])->name('inbox.show');    
Route::delete('/inbox/{id}', [InboxController::class, 'destroy'])->name('inbox.destroy');




 // Optional for listing all letters

 route::get('/Main', function () {
    return view('Main');
})->name('Main');


Route::get('Task Management/index', [TaskController::class, 'index'])
    ->name('Task Management.index');


Route::get('Task Management/create', [TaskController::class, 'create'])
    ->name('Task Management.create');

Route::post('Task Management/store', [TaskController::class, 'store'])
    ->name('Task Management.store');

Route::get('Task Management/{task}/edit', [TaskController::class, 'edit'])

    ->name('Task Management.edit'); 
Route::put('Task Management/{task}', [TaskController::class, 'update'])
    ->name('Task Management.update');

route::delete('Task Management/{task}', [TaskController::class, 'destroy'])
    ->name('Task Management.destroy');

route::get('Task Management/{task}', [TaskController::class, 'show'])
    ->name('Task Management.show');

    

route::get('new', function () {
    return view('new');
})->name('new');

route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');



// for Addministrations module

route::get('Administartions/create',[UserController::class, 'create'])
 ->name('Administrations.create');


route::get('Administrations/User Management', [UserController::class, 'index'])
    ->name('Administrations.User Management');

    route::get('Administrations/User Management/create', [UserController::class, 'create'])
        ->name('Administrations.User Management.create');

        route::get('Administrations/login', function () {
            return view('Administrations.login');
        })->name('Administrations.login');

        route::get('Administrations/Role Management', function () {
            return view('Administrations.Role Management');
        })->name('Administrations.Role Management');


  route::get('Administrations/Roles', function () {
    return view('Administrations.Roles');
})->name('Administrations.Roles');


// end roles management

Route::middleware(['auth'])->group(function () {

    Route::prefix('administrations')->group(function () {

        Route::get('/user-management/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/user-management', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/user-management/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/user-management/{user}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/user-management/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });
});



// admin settings route
route::get('admin/settings', function () {
    return view('admin.settings');
})->name('admin.settings');











// end admin settings route

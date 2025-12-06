<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});





// WEB ROUTES for inbox module//


Route::get('/CorrespondenceManagement/inbox/inbox', function () {
    return view ('CorrespondenceManagement.inbox.inbox');
});


Route::get('/CorrespondenceManagement/inbox/index', function () {
    return view ('CorrespondenceManagement.inbox.index');
});
// WEB ROUTES//end of inbox







Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('Layout.dashboard');
})->name('dashboard');


Route::get('/new', function () {
    return view('Layout.new');
})->name('new');





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


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');






Route::get('/CorrespondenceManagement/inbox/index', [InboxController::class, 'index'])->name('inbox.index');


Route::get('/CorrespondenceManagement/inbox/index', [InboxController::class, 'index'])
    ->name('inbox.index');

<?php
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

Route::group(['middleware' => CheckRole::class . ':admin'], function() {
    Route::inertia('/adminDashboard', 'AdminDashboard')->name('adminDashboard');
});
Route::group(['middleware' => CheckRole::class . ':user'], function() {
    Route::inertia('/userDashboard', 'UserDashboard')->name('userDashboard');
});
Route::group(['middleware' => CheckRole::class . ':guest'], function() {
    Route::inertia('/guestDashboard', 'GuestDashboard')->name('guestDashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
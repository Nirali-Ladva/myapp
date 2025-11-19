<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ChildController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
 * Utility: create initial admin (remove this in production)
 */
Route::get('/make-admin', function () {
    User::create([
        'name' => 'Admin',
        'email' => 'admin1@example.com',
        'password' => Hash::make('123456'),
        'profile_completed' => 0,
    ]);
    return "Admin created! <a href='/login'>Login Now</a>";
});

// test route (remove after debug)
Route::post('/__test-profile-update', function () {
    dd('test route hit');
});

Route::get('/', function () { return redirect()->route('login'); });

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // profile edit/update must be accessible while profile incomplete
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');

    // everything else requires completed profile
    Route::middleware(['profile.complete'])->group(function () {
        Route::get('dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');

        Route::resource('parents', ParentController::class);
        Route::post('parents/delete-multiple', [ParentController::class, 'destroy'])->name('parents.deleteMultiple');
        Route::post('parents/{parent}/delete-proof', [ParentController::class,'deleteProof'])->name('parents.deleteProof');

        Route::resource('children', ChildController::class);
        Route::post('children/delete-multiple', [ChildController::class,'destroy'])->name('children.deleteMultiple');
    });
});

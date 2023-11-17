<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TypeController;
use App\Models\Technology;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/* Admin routes */

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/projects', ProjectController::class)->parameters(['projects' => 'project:slug']);
    Route::get('trash', [ProjectController::class, 'trashed'])->name('trash');
    Route::put('trash/{project}/restore', [ProjectController::class, 'restoreTrashed'])->name('restore');
    //Route::delete('trash/{project}/destroy', [ProjectController::class, 'destroy'])->name('destroy');
    Route::delete('trash/{project}/destroy', [ProjectController::class, 'forceDelete'])->name('forceDelete');


    Route::resource('/types', TypeController::class)->parameters(['types' => 'type:slug']);

    Route::resource('/technologies', TechnologyController::class)->parameters(['technologies' => 'technology:slug']);
});


/* Profile views */

Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

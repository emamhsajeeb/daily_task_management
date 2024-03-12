<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
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
    return view('layouts/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tasks', [TaskController::class, 'show'])->middleware(['auth', 'verified'])->name('tasks');

Route::get('/add-tasks', function () {
    return view('task/add');
})->middleware(['auth', 'verified'])->name('add-tasks');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('task/import', [TaskController::class, 'import'])->name('task.import');

require __DIR__.'/auth.php';

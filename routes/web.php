<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
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
    $total = Tasks::count();
    $pending = Tasks::where('status', 'pending')->count();
    $completed = Tasks::where('status', 'completed')->count();
    $cancelled = Tasks::where('status', 'cancelled')->count();
    return view('layouts/dashboard',['user' => Auth::user(), 'title' => 'Dashboard', 'total' => $total,'pending' => $pending,'completed' => $completed,'cancelled' => $cancelled]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'showTasks'])->name('showTasks');
    Route::get('/add-tasks', [TaskController::class, 'addTasks'])->name('addTasks');
    Route::get('/export-tasks', [TaskController::class, 'exportTasks'])->name('exportTasks');
    Route::post('/task/import', [TaskController::class, 'importTasks'])->name('importTasks');
    Route::post('/task/update-inspection-details', [TaskController::class, 'updateInspectionDetails'])->name('updateInspectionDetails');
    Route::post('/task/update-status', [TaskController::class, 'updateTaskStatus'])->name('updateTaskStatus');
    Route::post('/task/update-rfi-submission-date', [TaskController::class, 'updateRfiSubmissionDate'])->name('updateRfiSubmissionDate');
    Route::post('/task/update-completion-date-time', [TaskController::class, 'updateCompletionDateTime'])->name('updateCompletionDateTime');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.view');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';

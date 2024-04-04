<?php

use App\Events\TasksImported;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\CheckRole;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PushNotificationController;

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
    $user = Auth::user();
    $tasks = $user->hasRole('se') ? Tasks::where('incharge', $user->user_name)->get() : Tasks::all();
    $total = $tasks->count();
    $completed = $tasks->where('status', 'completed')->count();
    $pending = $total - $completed;
    $rfi_submissions = $tasks->whereNotNull('rfi_submission_date')->count();
    $statistics = [
        'total' => $total,
        'completed' => $completed,
        'pending' => $pending,
        'rfi_submissions' => $rfi_submissions
    ];
    return view('layouts/dashboard',['title' => 'Dashboard', 'user' => $user,'statistics' => $statistics]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/update-device-token', [PushNotificationController::class, 'updateDeviceToken'])->name('updateDeviceToken');

Route::middleware([CheckRole::class . ':admin'])->group(function () {
    // Routes accessible only to users with the 'admin' role
    Route::get('/tasks-all', [TaskController::class, 'allTasks'])->name('allTasks');
    Route::post('/tasks-filtered', [TaskController::class, 'filterTasks'])->name('filterTasks');
    Route::get('/tasks', [TaskController::class, 'showTasks','title' => 'Task List'])->name('showTasks');
    Route::post('/task/add', [TaskController::class, 'addTask'])->name('addTask');
    Route::get('/task/import', [TaskController::class, 'importTasks'])->name('importTasks');
    Route::get('/export-tasks', [TaskController::class, 'exportTasks'])->name('exportTasks');
    Route::post('/task/import', [TaskController::class, 'importCSV'])->name('importCSV');
    Route::post('/task/update-rfi-submission-date', [TaskController::class, 'updateRfiSubmissionDate'])->name('updateRfiSubmissionDate');
    Route::post('/task/update-completion-date-time', [TaskController::class, 'updateCompletionDateTime'])->name('updateCompletionDateTime');
    Route::get('/tasks/daily-summary', [TaskController::class, 'showDailySummary','title' => 'Daily Summary'])->name('showDailySummary');
    Route::post('/tasks/daily-summary-filtered', [TaskController::class, 'filterSummary'])->name('filterSummary');
    Route::get('/tasks/daily-summary-export', [TaskController::class, 'exportDailySummary'])->name('exportDailySummary');

    Route::get('/team', [ProfileController::class, 'team'])->name('team');
    Route::post('/user/update-role', [ProfileController::class, 'updateUserRole'])->name('updateUserRole');


    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('editProfile');
    Route::post('/profile/update/{id}', [ProfileController::class, 'update'])->name('updateProfile');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('deleteUser');
});


Route::middleware([CheckRole::class . ':se'])->group(function () {
    Route::get('/tasks-all-se', [TaskController::class, 'allTasks'])->name('allTasksSE');
    Route::get('/tasks/se', [TaskController::class, 'showTasks'])->name('showTasksSE');
    Route::post('/task/add-se', [TaskController::class, 'addTask'])->name('addTaskSE');
    Route::post('/task/update-inspection-details', [TaskController::class, 'updateInspectionDetails'])->name('updateInspectionDetails');
    Route::post('/task/update-status', [TaskController::class, 'updateTaskStatus'])->name('updateTaskStatus');
    Route::post('/task/update-completion-date-time-se', [TaskController::class, 'updateCompletionDateTime'])->name('updateCompletionDateTimeSE');
    Route::get('/tasks/daily-summary-se', [TaskController::class, 'showDailySummary','title' => 'Daily Summary'])->name('showDailySummarySE');
    Route::post('/tasks/daily-summary-filtered-se', [TaskController::class, 'filterSummary'])->name('filterSummarySE');

});

Route::middleware('auth')->group(function () {
    Route::get('/tasks/daily-summary-json', [TaskController::class, 'dailySummary'])->name('dailySummary');
    Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('viewProfile');
});



require __DIR__.'/auth.php';

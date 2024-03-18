<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/tasks', [TaskController::class, 'index'])->middleware(['auth:sanctum', 'verified'])->name('api.tasks');

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

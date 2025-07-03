<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\Admin\AdminController;
use App\Modules\User\Controllers\Admin\AdminTaskController;




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

Route::post('/login', [AdminController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [AdminTaskController::class, 'index']);
    Route::post('/tasks', [AdminTaskController::class, 'store']);
    Route::put('/tasks/{task}', [AdminTaskController::class, 'update']);
    Route::delete('/tasks/{task}', [AdminTaskController::class, 'destroy']);
    Route::get('/tasks/trashed', [AdminTaskController::class, 'trashed']);
    Route::post('/tasks/{id}/restore', [AdminTaskController::class, 'restore']);
    Route::post('/import/template', [AdminTaskController::class, 'import']);
    Route::get('/template/download', [AdminTaskController::class, 'exportTemplate']);
    Route::delete('/tasks/{id}/force-delete', [AdminTaskController::class, 'forceDelete']);
});

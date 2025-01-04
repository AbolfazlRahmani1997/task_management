<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::group(['prefix'=>'auth'],function (){
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    Route::group(['prefix' => 'task', 'as' => 'task.','middleware'=>'auth:api'], function () {
        Route::get('/', [TaskController::class, 'index'])->middleware(['permission:show-task'])->name('index');
        Route::get('/{id}', [TaskController::class, 'show'])->middleware(['permission:show-task'])->name('show');
        Route::post('/', [TaskController::class, 'store'])->middleware(['permission:create-task'])->name('store');
        Route::put('/{id}', [TaskController::class, 'edit'])->middleware(['permission:update-task'])->name('edit');
        Route::delete('/', [TaskController::class, 'delete'])->middleware(['permission:delete-task'])->name('delete');

    });
    Route::group(['prefix' => 'user', 'as' => 'user.','middleware'=>'auth:api'], function () {
        Route::get('/', [UserController::class, 'index'])->middleware(['permission:view-user'])->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->middleware(['permission:view-user'])->name('show');
        Route::post('/', [UserController::class, 'store'])->middleware(['permission:create-user'])->name('store');
        Route::put('/{id}', [UserController::class, 'edit'])->middleware(['permission:update-user'])->name('edit');
        Route::delete('/', [UserController::class, 'delete'])->middleware(['permission:delete-user'])->name('delete');

    });
});

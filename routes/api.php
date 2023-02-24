<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoListController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('todo-list', TodoListController::class);
    Route::apiResource('todo-list.task', TaskController::class)->shallow();
});

Route::post('/register', [RegisterController::class,'register'])->name('user.register');
Route::post('/login', [LoginController::class,'login'])->name('user.login');

















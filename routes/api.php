<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// rota para requisição GET
Route::get('/users', [UserController::class, 'index']);

// rota para requisição POST
Route::post('/users', [UserController::class, 'store']);
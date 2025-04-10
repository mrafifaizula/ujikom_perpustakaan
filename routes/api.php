<?php

use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\BukuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [Authcontroller::class, 'login']);
Route::post('register', [Authcontroller::class, 'register']);
Route::post('logout', [Authcontroller::class, 'logout'])->middleware('auth:sanctum');

Route::get('buku', [BukuController::class, 'index']);
Route::get('buku/{id}', [BukuController::class, 'show']);
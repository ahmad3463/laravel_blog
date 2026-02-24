<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class,"registerUser"]);
Route::post('/login', [AuthController::class,"loginUsers"]);
Route::post('/create-post',[PostController::class,'createpost']);
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/token', function() {
    return response()->json([
        csrf_token()
    ]);
});

Route::post('/register', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'loginUser']);
Route::get('/items', [ItemController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);
Route::put('/orders/{id}/confirm', [OrderController::class, 'confirm']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/order', [OrderController::class, 'store']);
    Route::post('/logout', [UserController::class, 'logout']);
});
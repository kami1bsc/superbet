<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MainController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth Routes
Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);

//App Routes
Route::get('get-avatars', [MainController::class, 'get_avatars']);
Route::post('create-bet', [MainController::class, 'create_bet']);
Route::post('update-bet', [MainController::class, 'update_bet']);
Route::get('bet-details/{bet_id}', [MainController::class, 'bet_details']);
Route::get('bet-status/{user_id}', [MainController::class, 'bet_status']);
Route::get('select-winner/{bet_id}/{winner_id}', [MainController::class, 'select_winner']);
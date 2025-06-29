<?php

use App\Http\Controllers\RegisterController;
use App\Mapping\RoutesMapping;
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

Route::post('/'.RoutesMapping::ROUTE0, [RegisterController::class, 'register']);
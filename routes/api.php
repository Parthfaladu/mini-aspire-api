<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController, LoanController};

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
Route::post('/customer/register', [AuthController::class, 'customerRegister']);
Route::post('/admin/register', [AuthController::class, 'adminRegister']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/loan', [LoanController::class, 'create']);
    Route::get('/loan/{loan_id}', [LoanController::class, 'get']);
    Route::post('/loan/repayment', [LoanController::class, 'repayment']);

    // admin routes
    Route::post('/loan/approve', [LoanController::class, 'approve'])->middleware('role:admin');
});

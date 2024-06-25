<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post("mobilelogin",[AuthController::class,'mobileLogin']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('dashboard')->group(function() {
        Route::get('/',[DashboardController::class, 'index']);
        Route::get('/project/{id}',[DashboardController::class,'project']);
    });

    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::post("/create",[ProjectController::class, 'store']);
    });

    // Income routes
    Route::prefix('income')->group(function () {
        Route::get('/', [IncomeController::class, 'index']);
        Route::get('sum', [IncomeController::class, 'getGeneralIncomeSum']);
        Route::get("projectsum/today/{id}",[IncomeController::class, 'getIncomeSumToday']);
        Route::get("projectsum/{id}", [IncomeController::class, 'getProjectIncomeSum']);
        Route::post("store", [IncomeController::class, 'store']);
    });

    // Expenditure routes
    Route::prefix('expenditure')->group(function () {
        Route::get('/', [ExpenditureController::class, 'index']);
        Route::get('sum', [ExpenditureController::class, 'getGeneralExpenditureSum']);
        Route::get("projectsum/today/{id}",[ExpenditureController::class, 'getExpenditureSumToday']);
        Route::get("projectsum/{id}", [ExpenditureController::class, 'getProjectExpenditureSum']);
        Route::post("store", [ExpenditureController::class, 'store']);
    });
});

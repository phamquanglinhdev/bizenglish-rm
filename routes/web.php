<?php

use App\Http\Controllers\Admin\GradeCrudController;
use App\Http\Controllers\Admin\LogCrudController;
use App\Http\Controllers\Admin\StaffCrudController;
use App\Http\Controllers\Admin\StudentCrudController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->prefix("/")->group(function () {
    Route::get("/", function () {
        return view("layouts.app");
    })->name("index");
    Route::resource("grades", GradeCrudController::class);
    Route::resource("logs", LogCrudController::class);
    Route::resource("staffs", StaffCrudController::class);
    Route::resource("students", StudentCrudController::class);
});
Route::get("/login", [AuthController::class, "login"])->name("login");
Route::post("/login", [AuthController::class, "authenticate"])->name("authenticate");
Route::get("/logout", [AuthController::class, "logout"])->name("logout");

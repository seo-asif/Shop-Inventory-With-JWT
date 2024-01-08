<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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

Route::get('/', function () {
    return view('layout.sidenav-layout');
});

//Web Rest API
Route::post("/user-register", [UserController::class, 'registration']);
Route::post("/user-login", [UserController::class, 'login']);
Route::post("/send-otp", [UserController::class, 'sendOTPCode']);
Route::post("/verify-otp", [UserController::class, 'verifyOTPCode']);
Route::post("/reset-password", [UserController::class, 'resetPassword'])->middleware([TokenVerificationMiddleware::class]);

Route::get("/user-profile", [UserController::class, 'userProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/user-update", [UserController::class, 'updateProfile'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/logout', [UserController::class, 'userLogout']);

//Pages

Route::get('/login', [UserController::class, 'loginPage']);
Route::get('/registration', [UserController::class, 'registrationPage']);
Route::get('/sendotp', [UserController::class, 'sendOtpPage']);
Route::get('/verifyotp', [UserController::class, 'verifyOTPPage']);
Route::get('/resetpassword', [UserController::class, 'resetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/profile', [DashboardController::class, 'profilePage'])->middleware([TokenVerificationMiddleware::class]);

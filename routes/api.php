<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\MedicienController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AnimalController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/auth/google','googleLogin');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

Route::controller(MedicienController::class)->group(function () {
    Route::get('/mediciens/show', 'show');
});

Route::controller(ProfileController::class)->group(function () {
    Route::middleware('auth:sanctum')->get('/profile', 'profile');
    Route::middleware('auth:sanctum')->post('/edit-profile', 'editProfile');
});

Route::middleware('auth:sanctum')->controller(CartController::class)->group(function () {
    Route::post('/cart/add', 'add');
    Route::post('/cart/change-quantity', 'changeQuantity');
    Route::get('/cart/view', 'view');
    Route::post('/cart/remove', 'remove');
    Route::post('/cart/clear', 'clear');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout']);
});

Route::controller(ClinicController::class)->group(function () {
    Route::get('/clinics', 'index');
    Route::get('/clinics/{id}', 'show');
});

Route::middleware('auth:sanctum')->controller(BookingController::class)->group(function () {
    Route::post('/book-appointment', 'bookAppointment');
    Route::get('/user-bookings', 'getUserBookings');
});

Route::middleware('auth:sanctum')->controller(AnimalController::class)->group(function () {
    Route::post('/enter-animal', 'enterAnimal');
    Route::get('/get-animals', 'getAnimals');
});
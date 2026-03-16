<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\PharmacyController;
use App\Http\Controllers\Web\ClinicController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\OrdersController;
use App\Http\Controllers\Web\VaccinationController;

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

Route::middleware('admin')->controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard.index');
});

Route::middleware('admin')->controller(PharmacyController::class)->group(function () {
    Route::get('/dashboard/pharmacy/create', 'showCreate')->name('pharmacy.create');
    Route::post('/dashboard/pharmacy/store', 'store')->name('pharmacy.store');
    Route::get('/dashboard/pharmacy/edit/{id}', 'edit')->name('pharmacy.edit');
    Route::PUT('/dashboard/pharmacy/update/{id}', 'update')->name('pharmacy.update');
    Route::get('/dashboard/pharmacy/show', 'show')->name('pharmacy.show');
    Route::delete('/dashboard/pharmacy/delete/{id}', 'destroy')->name('pharmacy.delete');
});

Route::middleware('admin')->controller(ClinicController::class)->group(function () {
    Route::get('/dashboard/clinic/create', 'showCreate')->name('clinic.create');
    Route::post('/dashboard/clinic/store', 'store')->name('clinic.store');
    Route::get('/dashboard/clinic/edit/{id}', 'edit')->name('clinic.edit');
    Route::PUT('/dashboard/clinic/update/{id}', 'update')->name('clinic.update');
    Route::get('/dashboard/clinic/show', 'show')->name('clinic.show');
    Route::delete('/dashboard/clinic/delete/{id}', 'destroy')->name('clinic.delete');
});

Route::middleware('admin')->controller(BookingController::class)->group(function () {
    Route::get('/dashboard/booking', 'index')->name('booking.index');
    Route::post('/dashboard/booking/confirm/{id}', 'confirm')->name('booking.confirm');
    Route::post('/dashboard/booking/cancel/{id}', 'cancel')->name('booking.cancel');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/dashboard/login', 'showLoginForm')->name('dashboard.login');
    Route::post('/dashboard/auth/login', 'login')->name('dashboard.login.submit');
    Route::post('/dashboard/logout', 'logout')->name('dashboard.logout');

});

Route::middleware('admin')->controller(OrdersController::class)->group(function () {
    Route::get('/dashboard/orders', 'index')->name('orders.index');
    Route::get('/dashboard/orders/viewdetails/{id}', 'viewDetails')->name('orders.viewdetails');
    Route::post('/dashboard/orders/confirm/{id}', 'confirmOrder')->name('orders.confirm');
    Route::post('/dashboard/orders/ship/{id}', 'shipOrder')->name('orders.ship');
});

Route::middleware('admin')->controller(VaccinationController::class)->group(function () {
    Route::get('/dashboard/vaccination/create', 'createVaccination')->name('vaccination.create');
    Route::post('/dashboard/vaccination/store', 'storeNewVaccination')->name('vaccination.store');
    Route::get('/dashboard/vaccination/show', 'showVaccination')->name('vaccination.show');
    Route::get('/dashboard/vaccination/edit/{id}', 'editVaccination')->name('vaccination.edit');
    Route::PUT('/dashboard/vaccination/update/{id}', 'updateVaccination')->name('vaccination.update');  
    Route::delete('/dashboard/vaccination/delete/{id}', 'deleteVaccination')->name('vaccination.delete');
});    


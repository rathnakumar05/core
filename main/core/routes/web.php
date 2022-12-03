<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\MachinesController;
use App\Http\Controllers\ServicesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/{dashboard}', function () {
    return view('dashboard');
})->where('dashboard', '(|dashboard)')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->name('devices.')->prefix('devices')->group(function() {
    Route::get('', [DevicesController::class, 'index'])->name('index');
    Route::post('/store', [DevicesController::class, 'store'])->name('store');
    Route::post('/delete', [DevicesController::class, 'destroy'])->name('delete');
});

Route::middleware(['auth', 'verified'])->name('machines.')->prefix('machines')->group(function() {
    Route::get('', [MachinesController::class, 'index'])->name('index');
    Route::post('/action', [MachinesController::class, 'action'])->name('action');
});

Route::middleware(['auth', 'verified'])->name('services.')->prefix('services')->group(function() {
    Route::get('', [ServicesController::class, 'index'])->name('index');
    Route::get('/mysql', [ServicesController::class, 'mysql'])->name('mysql');
    Route::post('/mysql/add/user', [ServicesController::class, 'mysqladdu'])->name('mysqladdu');
    Route::post('/mysql/add/database', [ServicesController::class, 'mysqladdd'])->name('mysqladdd');
    Route::post('/mysql/delete/user', [ServicesController::class, 'mysqldelu'])->name('mysqldelu');
    Route::post('/mysql/delete/database', [ServicesController::class, 'mysqldeld'])->name('mysqldeld');
});


Route::get('send-mail', function () {
   
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    dd(\Mail::to('rathnak010@gmail.com')->send(new \App\Mail\TestMail($details)));
   
    dd("Email is Sent.");
});

<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

Route::get('/index', [userController::class, "index"])->name('index');
Route::get('/resource-availability', [UserController::class, 'showResourceAvailability'])->name('resource.availability');
Route::post('/submit-patient', [App\Http\Controllers\userController::class, 'submitPatientForm'])->name('submit.patient.form');
Route::get('/verify', [userController::class, 'showForm']);
Route::post('/verify', [userController::class, 'checkHash'])->name('verify.hash');
Route::get('/verify', [userController::class, 'verify'])->name('verify');
<?php

use Illuminate\Support\Facades\Route;
use Wing5wong\KamarDirectoryServices\Controllers\HandleKamarEmergency;
use Wing5wong\KamarDirectoryServices\Controllers\HandleKamarPost;

Route::middleware('kamar')->post('/kamar', HandleKamarPost::class)->name('kamar');
Route::middleware('kamar')->post('/kamar/emergency', HandleKamarEmergency::class)->name('emergency');

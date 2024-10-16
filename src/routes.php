<?php

use Illuminate\Support\Facades\Route;
use Wing5wong\KamarDirectoryServices\Controllers\HandleEmergency;
use Wing5wong\KamarDirectoryServices\Controllers\HandleKamarPost;

Route::middleware('kamar')->post('/kamar', HandleKamarPost::class)->name('kamar');
Route::middleware('kamar')->post('/kamar/emergency', HandleEmergency::class)->name('emergency');

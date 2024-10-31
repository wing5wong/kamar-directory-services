<?php

use Illuminate\Support\Facades\Route;
use Wing5wong\KamarDirectoryServices\Controllers\HandleEmergency;
use Wing5wong\KamarDirectoryServices\Controllers\HandleKamarPost;

Route::prefix('kamar')->middleware('kamar')->group(function () {
    Route::post('/', HandleKamarPost::class)->name('kamar');
    Route::post('/emergency', HandleEmergency::class)->name('kamar.emergency');
});

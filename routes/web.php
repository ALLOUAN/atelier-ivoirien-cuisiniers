<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::controller(SiteController::class)->group(function () {
    Route::get('/formations/{slug}', 'training')->name('training');
    Route::get('/{page?}', 'page')->where('page', '[a-z\-]+(/[a-z\-]+)?')->name('page');
});

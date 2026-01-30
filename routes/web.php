<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookLookupController;


Route::get('/', BookLookupController::class)->name('isbn.lookup');
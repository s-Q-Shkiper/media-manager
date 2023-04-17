<?php

use Illuminate\Support\Facades\Route;

Route::get('/mediamanager', [ \sQShkiper\MediaManager\Http\Controllers\MediaController::class, 'index']);

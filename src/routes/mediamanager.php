<?php

use Illuminate\Support\Facades\Route;

Route::get('/mediamanager', [ \Shkiper\MediaManager\Http\Controllers\MediaController::class, 'index']);

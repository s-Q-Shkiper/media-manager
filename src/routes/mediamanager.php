<?php

use Illuminate\Support\Facades\Route;

Route::get('/mediamanager', [ \Shkiper\MediaManager\Http\Controllers\MediaController::class, 'index']);
Route::post('/mediamanager/uploadFiles', [ \Shkiper\MediaManager\Http\Controllers\MediaController::class, 'uploadFiles']);
Route::post('/mediamanager/createFolder', [ \Shkiper\MediaManager\Http\Controllers\MediaController::class, 'createFolder']);
Route::post('/mediamanager/updateMedia', [ \Shkiper\MediaManager\Http\Controllers\MediaController::class, 'updateMedia']);
Route::post('/mediamanager/deleteMedia', [ \Shkiper\MediaManager\Http\Controllers\MediaController::class, 'delete']);
Route::post('/mediamanager/openFolder', [ \Shkiper\MediaManager\Http\Controllers\MediaController::class, 'openFolder']);

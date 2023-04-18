<?php

namespace Shkiper\MediaManager\Http\Controllers;

use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function index(){
        return view('mediamanager::index');
    }
}

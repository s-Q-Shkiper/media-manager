<?php

namespace Shkiper\MediaManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'path_name',
        'extension',
        'path',
        'sort',
    ];


}

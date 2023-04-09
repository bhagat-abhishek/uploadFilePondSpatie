<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TemporaryFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

}

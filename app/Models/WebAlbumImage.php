<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class WebAlbumImage extends Model
{
    use HasFactory;
     use Loggable;
    protected $guarded = [];
}
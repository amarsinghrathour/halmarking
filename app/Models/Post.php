<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class Post extends Model
{
    use HasFactory;
    use Loggable;
    public function category()
    {
        return $this->hasOne('\App\Models\PostCategory','id','category_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class Category extends Model
{
    use HasFactory;
    use Loggable;
    protected $guarded = [];
    protected $dates = ['created_at'];
    public function posts()
    {
        return $this->hasMany('\App\Models\Post','category_id','id');
    }
}

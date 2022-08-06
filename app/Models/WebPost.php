<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class WebPost extends Model
{
    use HasFactory;
    use Loggable;
    protected $guarded = [];
    protected $table = 'web_contents';
    public function category()
    {
        return $this->hasOne('\App\Models\Category','id','category_id');
    }
    public function sub_category()
    {
        return $this->hasOne('\App\Models\Category','id','sub_category_id');
    }
}

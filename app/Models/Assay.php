<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class Assay extends Model
{
    use Loggable;
    protected $guarded = [];
    use HasFactory;
   
     public function customer()
    {
        return $this->hasOne(Job::class,'job_no','job_no');
    }
}

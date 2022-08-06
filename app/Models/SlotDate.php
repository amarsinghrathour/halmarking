<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Models\SlotTime;
class SlotDate extends Model
{
     use HasFactory;
    use Loggable;
    protected $guarded = [];
    
    public function slot_time()
    {
        return $this->hasMany(SlotTime::class,'slot_date_id','id');
    }
    
}

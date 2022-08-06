<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class UpcomingEvent extends Model
{
    use HasFactory;
    use Loggable;
    protected $guarded = [];
    protected $dates = ['event_date','created_at'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class Appointment extends Model
{
     use HasFactory;
    use Loggable;
    protected $guarded = [];
     public function history()
    {
        return $this->hasMany(AppointmentHistory::class,'appointment_id','id');
    }
     public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }
}

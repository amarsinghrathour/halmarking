<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class Job extends Model
{
    use Loggable;
    protected $guarded = [];
    use HasFactory;
    public function assay()
    {
        return $this->hasMany(Assay::class,'job_no','job_no');
    }
}

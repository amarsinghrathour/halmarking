<?php

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable
{
    protected $attributes = [
        'status' => 'ACTIVE',
    ];
    use Notifiable, HasRoles;
    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    function role() {
        return $this->hasOne('Spatie\Permission\Models\Role','id','role_id');
        
    }
    
}

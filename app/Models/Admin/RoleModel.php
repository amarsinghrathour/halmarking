<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Admin;

/**
 * Description of RoleModel
 *
 * @author singh
 */
use Illuminate\Database\Eloquent\Model;
class RoleModel extends Model
{
    protected $table = 'roles';
   const CREATED_AT = 'created_date';
   
   protected $attributes = [
        'status' => 'ACTIVE',
    ];
    
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Admin;

/**
 * Description of MenuMappingModel
 *
 * @author singh
 */
use \Illuminate\Database\Eloquent\Model;
class MenuMappingModel extends Model
{
   protected $table = 'menu_mapping';
   const CREATED_AT = 'created_date';
   const UPDATED_AT = 'updated_date';
   protected $attributes = [
        'status' => 'ACTIVE',
    ];
   
    public function menu()
    {
        return $this->belongsTo('\App\Http\Models\Admin\MenuModel');
    }
   
}

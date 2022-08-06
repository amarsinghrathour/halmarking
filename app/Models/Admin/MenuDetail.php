<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuMapping;

class MenuDetail extends Model
{
    use HasFactory;
    
    public function menu_mapping() {
        return $this->hasMany(MenuMapping::class,'menu_id','id');
    }
    protected $table = 'menu_detail';
}

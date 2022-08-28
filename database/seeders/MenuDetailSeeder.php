<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MenuDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
     // dashboard 
        $data[] = [
            'name' => 'Dashboard',
            'url' => '/dashboard',
            'menu_order' => 0,
            'parent_id' => 0,
            'icon' => 'dashboard',
            'title' => 'All Role Dashboard',
            
            'created_by' => 'Seeder',
            'status' => 'ACTIVE',
        ];
        
       
     //   Category
        $data[] = [
            'name' => 'Jobs',
            'url' => '#',
            'menu_order' => 1,
            'parent_id' => 0,
            'icon' => 'drag_indicator',
            'title' => 'Manage Category',
            
            'created_by' => 'Seeder',
            'status' => 'ACTIVE',
        ];
        
     //  Add Category
        $data[] = [
            'name' => 'Add Category',
            'url' => '/jobs/add',
            'menu_order' => 0,
            'parent_id' => 2,
            'icon' => 'Add',
            'title' => 'Add Job',
            
            'created_by' => 'Seeder',
            'status' => 'ACTIVE',
        ];
        
     //  Category List
        $data[] = [
            'name' => 'Job List',
            'url' => '/jobs',
            'menu_order' => 2,
            'parent_id' => 2,
            'icon' => 'list',
            'title' => 'List Job',
            
            'created_by' => 'Seeder',
            'status' => 'ACTIVE',
        ];
        
        
        DB::table('menu_detail')->insert($data);
    }
}

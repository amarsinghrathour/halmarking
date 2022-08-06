<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MenuMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = [
        'menu_id' => 1,
        'role_id' => 1,
        'add_access' => 1,
        'edit_access' => 1,
        'delete_access' => 1,
        
        'created_by' => 'Seeder',
        'status' => 'ACTIVE'];
        
        $data[] = [
        'menu_id' => 2,
        'role_id' => 1,
        'add_access' => 1,
        'edit_access' => 1,
        'delete_access' => 1,
        
        'created_by' => 'Seeder',
        'status' => 'ACTIVE'];
        
        $data[] = [
        'menu_id' => 3,
        'role_id' => 1,
        'add_access' => 1,
        'edit_access' => 1,
        'delete_access' => 1,
        
        'created_by' => 'Seeder',
        'status' => 'ACTIVE'];
        
        // menu 4       
        $data[] = [
        'menu_id' => 4,
        'role_id' => 1,
        'add_access' => 1,
        'edit_access' => 1,
        'delete_access' => 1,
        
        'created_by' => 'Seeder',
        'status' => 'ACTIVE'];
        
        DB::table('menu_mapping')->insert($data);
    }
}

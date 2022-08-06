<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        // Top Role
        $data[] = [
            'name' => 'Administrative',
            'parent_id' => 0,
            'created_date' => now(),
            'created_by' => 'Seeder',
            'status' => 'ACTIVE',
        ];
        $data[] = [
            'name' => 'Admin',
            'parent_id' => 0,
            'created_date' => now(),
            'created_by' => 'Seeder',
            'status' => 'ACTIVE',
        ];
        $data[] = [
            'name' => 'Staff',
            'parent_id' => 0,
            'created_date' => now(),
            'created_by' => 'Seeder',
            'status' => 'INACTIVE',
        ];
        $data[] = [
            'name' => 'Editor',
            'parent_id' => 0,
            'created_date' => now(),
            'created_by' => 'Seeder',
            'status' => 'INACTIVE',
        ];
        $data[] = [
            'name' => 'Member',
            'parent_id' => 0,
            'created_date' => now(),
            'created_by' => 'Seeder',
            'status' => 'INACTIVE',
        ];
        DB::table('roles')->insert($data);
    }
}

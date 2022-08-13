<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           
           'job-list',
           'job-create',
           'job-edit',
           'job-delete',
          
           'assay-list',
           'assay-create',
           'assay-edit',
           'assay-delete',
           
           'settings-list',
           'settings-create',
           'settings-edit',
           'settings-delete',
           
           
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission,'guard_name'=>'admin']);
        }
    }
}

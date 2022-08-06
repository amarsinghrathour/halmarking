<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user = Admin::create([
            'name' => 'Super Admin',
        'email' => 'admin@gmail.com',
        'email_verified_at' => now(),
        'password' => Hash::make('Admin@123'), // password Admin@123
        'remember_token' => Str::random(10),
        'role_id' => 1
        ]);
    
        $role = Role::create(['name' => 'SuperAdmin','guard_name'=>'admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
        
    }
}

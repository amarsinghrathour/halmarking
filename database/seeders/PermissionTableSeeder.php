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
           'web_slider-list',
           'web_slider-create',
           'web_slider-edit',
           'web_slider-delete',
           'web_album-list',
           'web_album-create',
           'web_album-edit',
           'web_album-delete',
           'web_album_image-list',
           'web_album_image-create',
           'web_album_image-edit',
           'web_album_image-delete',
           'upcoming_event-list',
           'upcoming_event-create',
           'upcoming_event-edit',
           'upcoming_event-delete',
           'recent_activity-list',
           'recent_activity-create',
           'recent_activity-edit',
           'recent_activity-delete',
           'notice_board-list',
           'notice_board-create',
           'notice_board-edit',
           'notice_board-delete',
           'web_menu-list',
           'web_menu-create',
           'web_menu-edit',
           'web_menu-delete',
           'web_page-list',
           'web_page-create',
           'web_page-edit',
           'web_page-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'web_post-list',
           'web_post-create',
           'web_post-edit',
           'web_post-delete',
           'enquiry-list',
           'enquiry-create',
           'enquiry-edit',
           'enquiry-delete',
           'customer-list',
           'customer-create',
           'customer-edit',
           'customer-delete',
           'settings-list',
           'settings-create',
           'settings-edit',
           'settings-delete',
           'slot-list',
           'slot-create',
           'slot-edit',
           'slot-delete',
           
           'appointment-list',
           'appointment-create',
           'appointment-edit',
           'appointment-delete',
           
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission,'guard_name'=>'admin']);
        }
    }
}

<?php
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
     $exitCode = Artisan::call('config:cache');
});
Route::group(["namespace"=>"Auth"],function() {
        Route::get('/','LoginController@showLoginForm')->name('admin.login');
        Route::post('/login','LoginController@login')->name('admin.processlogin');
        Route::post('/logout','LoginController@logout')->name('admin.logout');
        
    });
    
   Route::group(['middleware' => 'auth:admin'], function()
{ 
       
       // Admin Routes
    Route::get('/dashboard','HomeController@index')->name('admin.dashboard');
    
    //Open Locked Screen Page
        Route::get('/locked-screen','LockscreenController@showLockedScreen'
        )->name('locked-screen');

        //Do Screen Locked
    Route::get('/lock-screen','LockscreenController@screenLocked'
    )->name('lock-screen');

    //Do Screen UnLocked
    Route::post('/unlocked-screen','LockscreenController@screenUnLocked'
    )->name('unlocked-screen');
       
    // User
    Route::get('/user', 'AdminController@index')->name('admin.user');
    Route::get('/user/add', 'AdminController@add')->name('admin.user.add');
    Route::get('/user/edit/{id}', 'AdminController@edit')->name('admin.user.edit');
    Route::post('/user/save', 'AdminController@save')->name('admin.user.save');
    Route::post('/user/update', 'AdminController@update')->name('admin.user.update');
    Route::post('/user/update-password', 'AdminController@updatePassword')->name('admin.user.updatepwd');
    
    
    //Role
    Route::get('/role', 'RoleController@index')->name('admin.roles');
    Route::get('/role/add', 'RoleController@add')->name('admin.roles.add');
    Route::post('/role/save', 'RoleController@save')->name('admin.roles.save');
    Route::get('/role/edit/{id}', 'RoleController@edit')->name('admin.roles.edit');
    Route::get('/role/show/{id}', 'RoleController@show')->name('admin.roles.show');
    Route::get('/role/destroy/{id}', 'RoleController@destroy')->name('admin.roles.destroy');
    Route::post('/role/update', 'RoleController@update')->name('admin.roles.update');
    
    
    //Customer
    Route::get('/customer', 'CustomerController@index')->name('admin.customer');
    Route::get('/customer/add', 'CustomerController@add')->name('admin.customer.add');
    Route::post('/customer/save', 'CustomerController@save')->name('admin.customer.save');
    Route::get('/customer/edit/{id}', 'CustomerController@edit')->name('admin.customer.edit');
    Route::post('/customer/update', 'CustomerController@update')->name('admin.customer.update');
    
   
    #####################################
    // Website
    Route::get('/web_slider', 'WebSliderController@index')->name('admin.web_slider');
    Route::get('/web_slider/add', 'WebSliderController@add')->name('admin.web_slider.add');
    Route::post('/web_slider/save', 'WebSliderController@save')->name('admin.web_slider.save');
    Route::get('/web_slider/edit/{id}', 'WebSliderController@edit')->name('admin.web_slider.edit');
    Route::post('/web_slider/update', 'WebSliderController@update')->name('admin.web_slider.update');
    Route::post('/web_slider/update/sort_order', 'WebSliderController@updateSortOrder')->name('admin.web_slider.sort_order.update');
    
    #####################################
    // Website Album
    Route::get('/web_album', 'WebAlbumController@index')->name('admin.web_album');
    Route::get('/web_album/add', 'WebAlbumController@add')->name('admin.web_album.add');
    Route::post('/web_album/save', 'WebAlbumController@save')->name('admin.web_album.save');
    Route::get('/web_album/edit/{id}', 'WebAlbumController@edit')->name('admin.web_album.edit');
    Route::post('/web_album/update', 'WebAlbumController@update')->name('admin.web_album.update');
    Route::post('/web_album/update/sort_order', 'WebAlbumController@updateSortOrder')->name('admin.web_album.sort_order.update');
    
    #####################################
    // Website Album Image
    Route::get('/web_album_image/{album_slug}', 'WebAlbumImageController@index')->name('admin.web_album_image');
    Route::get('/web_album_image/add/{album_id}', 'WebAlbumImageController@add')->name('admin.web_album_image.add');
    Route::post('/web_album_image/save', 'WebAlbumImageController@save')->name('admin.web_album_image.save');
    Route::get('/web_album_image/edit/{id}', 'WebAlbumImageController@edit')->name('admin.web_album_image.edit');
    Route::post('/web_album_image/update', 'WebAlbumImageController@update')->name('admin.web_album_image.update');
    Route::post('/web_album_image/update/sort_order', 'WebAlbumImageController@updateSortOrder')->name('admin.web_album_image.sort_order.update');
    
    #####################################
    // Upcoming Events
    Route::get('/upcoming_event', 'UpcomingEventController@index')->name('admin.upcoming_event');
    Route::get('/upcoming_event/add', 'UpcomingEventController@add')->name('admin.upcoming_event.add');
    Route::post('/upcoming_event/save', 'UpcomingEventController@save')->name('admin.upcoming_event.save');
    Route::get('/upcoming_event/edit/{id}', 'UpcomingEventController@edit')->name('admin.upcoming_event.edit');
    Route::post('/upcoming_event/update', 'UpcomingEventController@update')->name('admin.upcoming_event.update');
    Route::post('/upcoming_event/update/sort_order', 'UpcomingEventController@updateSortOrder')->name('admin.upcoming_event.sort_order.update');
        
    #####################################
    // recent_activity
    Route::get('/recent_activity', 'RecentActivityController@index')->name('admin.recent_activity');
    Route::get('/recent_activity/add', 'RecentActivityController@add')->name('admin.recent_activity.add');
    Route::post('/recent_activity/save', 'RecentActivityController@save')->name('admin.recent_activity.save');
    Route::get('/recent_activity/edit/{id}', 'RecentActivityController@edit')->name('admin.recent_activity.edit');
    Route::post('/recent_activity/update', 'RecentActivityController@update')->name('admin.recent_activity.update');
    Route::post('/recent_activity/update/sort_order', 'RecentActivityController@updateSortOrder')->name('admin.recent_activity.sort_order.update');
    
    #####################################
    // notive board
    Route::get('/notice_board', 'NoticeBoardController@index')->name('admin.notice_board');
    Route::get('/notice_board/add', 'NoticeBoardController@add')->name('admin.notice_board.add');
    Route::post('/notice_board/save', 'NoticeBoardController@save')->name('admin.notice_board.save');
    Route::get('/notice_board/edit/{id}', 'NoticeBoardController@edit')->name('admin.notice_board.edit');
    Route::post('/notice_board/update', 'NoticeBoardController@update')->name('admin.notice_board.update');
    Route::post('/notice_board/update/sort_order', 'NoticeBoardController@updateSortOrder')->name('admin.notice_board.sort_order.update');
       
    #####################################
    // Web Menus
    Route::get('/web_menu', 'WebMenuController@index')->name('admin.web_menu');
    Route::get('/web_menu/add', 'WebMenuController@add')->name('admin.web_menu.add');
    Route::post('/web_menu/save', 'WebMenuController@save')->name('admin.web_menu.save');
    Route::get('/web_menu/edit/{id}', 'WebMenuController@edit')->name('admin.web_menu.edit');
    Route::post('/web_menu/update', 'WebMenuController@update')->name('admin.web_menu.update');
    Route::post('/web_menu/update/position', 'WebMenuController@menuposition')->name('admin.web_menu.position');
    Route::post('/web_menu/delete', 'WebMenuController@delete')->name('admin.web_menu.delete');
    
     #####################################
    // Web Page
    Route::get('/web_page', 'WebPageController@index')->name('admin.web_page');
    Route::get('/web_page/add', 'WebPageController@add')->name('admin.web_page.add');
    Route::post('/web_page/save', 'WebPageController@save')->name('admin.web_page.save');
    Route::get('/web_page/edit/{id}', 'WebPageController@edit')->name('admin.web_page.edit');
    Route::post('/web_page/update', 'WebPageController@update')->name('admin.web_page.update');
    
    //manage post Category
    Route::get('category/add', 'CategoryController@add')->name('admin.category.add');
    Route::post('category/save', 'CategoryController@save')->name('admin.category.save');
    Route::get('category', 'CategoryController@index')->name('admin.category.list');
    Route::get('category/edit/{id}', 'CategoryController@edit')->name('admin.category.edit');
    Route::post('category/update', 'CategoryController@update')->name('admin.category.update');
    Route::post('category/update/is_top', 'CategoryController@updateIsTop')->name('admin.category.update.is_top');
    Route::post('category/update/sort_order', 'CategoryController@updateSortOrder')->name('admin.category.update.sort_order');
    
    // Web Post
    Route::get('/web_post', 'WebPostController@index')->name('admin.web_post');
    Route::get('/web_post/add', 'WebPostController@add')->name('admin.web_post.add');
    Route::post('/web_post/save', 'WebPostController@save')->name('admin.web_post.save');
    Route::get('/web_post/edit/{id}', 'WebPostController@edit')->name('admin.web_post.edit');
    Route::post('/web_post/update', 'WebPostController@update')->name('admin.web_post.update');
    Route::post('/web_post/ajax/sub_category', 'WebPostController@get_sub_category_ajax')->name('admin.web_post.ajax.subcategory');
    
    #####################################
    // Settings

    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings/update', 'SettingController@update')->name('settings.update');
    
   
   //manage Services
    Route::get('service/add', 'ServiceController@add')->name('admin.service.add');
    Route::post('service/save', 'ServiceController@save')->name('admin.service.save');
    Route::get('service', 'ServiceController@index')->name('admin.service.list');
    Route::get('service/edit/{id}', 'ServiceController@edit')->name('admin.service.edit');
    Route::post('service/update', 'ServiceController@update')->name('admin.service.update');
    Route::post('service/update/is_show_on_home', 'ServiceController@updateIsTop')->name('admin.service.update.is_show_on_home');
    
   ##################################################################################################
   #  App Management
   #################################################################################################
   //Customer
    Route::get('/slot', 'SlotDateController@index')->name('admin.slot');
    Route::get('/slot/add', 'SlotDateController@add')->name('admin.slot.add');
    Route::post('/slot/save', 'SlotDateController@save')->name('admin.slot.save');
    Route::get('/slot/edit/{id}', 'SlotDateController@edit')->name('admin.slot.edit');
    Route::post('/slot/update', 'SlotDateController@update')->name('admin.slot.update');
    
    //Appointment
    Route::get('/appointment', 'AppointmentController@index')->name('admin.appointment');
    Route::get('/appointment/add', 'AppointmentController@add')->name('admin.appointment.add');
    Route::post('/appointment/save', 'AppointmentController@save')->name('admin.appointment.save');
    Route::get('/appointment/edit/{id}', 'AppointmentController@edit')->name('admin.appointment.edit');
    Route::get('/appointment/view/{id}', 'AppointmentController@view')->name('admin.appointment.view');
    Route::post('/appointment/update', 'AppointmentController@update')->name('admin.appointment.update');
    
      
       
    // Enquiry
    Route::get('/enquiry', 'EnquiryController@index')->name('admin.enquiry');
    
     
    //change status
Route::post('/changestatus', 'ChangestatusController@changeStatus')->name('change.status');

    
   
    
});
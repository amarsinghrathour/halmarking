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
    
    
    
    //manage post Category
    Route::get('category/add', 'CategoryController@add')->name('admin.category.add');
    Route::post('category/save', 'CategoryController@save')->name('admin.category.save');
    Route::get('category', 'CategoryController@index')->name('admin.category.list');
    Route::get('category/edit/{id}', 'CategoryController@edit')->name('admin.category.edit');
    Route::post('category/update', 'CategoryController@update')->name('admin.category.update');
    Route::post('category/update/is_top', 'CategoryController@updateIsTop')->name('admin.category.update.is_top');
    Route::post('category/update/sort_order', 'CategoryController@updateSortOrder')->name('admin.category.update.sort_order');
    
   
    #####################################
    //Jobs
    //manage post Category
    Route::get('jobs/add', 'JobController@add')->name('admin.job.add');
    Route::post('jobs/save', 'JobController@save')->name('admin.job.save');
    Route::get('jobs', 'JobController@index')->name('admin.job.list');
    Route::get('jobs/edit/{id}', 'JobController@edit')->name('admin.job.edit');
    Route::post('jobs/update', 'JobController@update')->name('admin.job.update');
    
    #####################################
    // Settings

    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings/update', 'SettingController@update')->name('settings.update');
    
   
   
     
    //change status
Route::post('/changestatus', 'ChangestatusController@changeStatus')->name('change.status');

    
   
    
});
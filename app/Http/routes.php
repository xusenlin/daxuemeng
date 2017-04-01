<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




/*
|--------------------------------------------------------------------------
| 前台路由
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {


    Route::auth();

    Route::get('/', 'HomeController@index');

    Route::get('/home', 'HomeController@index');
});


/*
|--------------------------------------------------------------------------
| 后台路由
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web','auth'],'prefix' => 'admin','namespace' => 'Admin'], function () {

    /**
     * Home控制器
     */
    Route::get('/',['as' => 'admin', 'uses' => 'HomeController@home']);

    /**
     * 个人中心
     */
    Route::group(['namespace' => 'Personal'], function () {

        Route::get('/personal_center',['as' => 'admin.personal_center', 'uses' => 'IndexController@index']);

    });

    /**
     * 用户管理
     */
    Route::group(['namespace' => 'Users'], function () {

        //用户列表
        Route::get('/users',['as' => 'admin.users', 'uses' => 'IndexController@index']);
        //禁用用户
        Route::get('/user_disabled/{user_id?}',['as' => 'admin.users_disabled', 'uses' => 'IndexController@disabled']);

    });

    /**
     * 生活管理
     */
    Route::group(['namespace' => 'Life'], function () {
        //兼职列表
        Route::get('/part_time_job',['as' => 'admin.part_time_job', 'uses' => 'JobController@index']);
        //添加或者编辑兼职
        Route::get('/part_time_job_add/{job_id?}',['as' => 'admin.part_time_job_add', 'uses' => 'JobController@add']);
        //保存兼职数据
        Route::post('/part_time_job_save',['as' => 'admin.part_time_job_save', 'uses' => 'JobController@save']);
        //删除兼职数据
        Route::get('/part_time_job_delete/{job_id?}',['as' => 'admin.part_time_job_delete', 'uses' => 'JobController@delete']);
        
        //租赁列表
        Route::get('/lease_list',['as' => 'admin.leases_list', 'uses' => 'LeaseController@index']);
        //添加或者编辑租赁
        Route::get('/lease_add/{lease_id?}',['as' => 'admin.leases_add', 'uses' => 'LeaseController@add']);
        //保存租赁数据
        Route::post('/lease_save',['as' => 'admin.leases_save', 'uses' => 'LeaseController@save']);
        //删除租赁数据
        Route::get('/lease_delete/{lease_id?}',['as' => 'admin.lease_delete', 'uses' => 'LeaseController@delete']);


        //驾校列表
        Route::get('/driving_school_list',['as' => 'admin.driving_list', 'uses' => 'DrivingController@index']);
        //添加或者编辑驾校
        Route::get('/driving_school_add/{info_id?}',['as' => 'admin.driving_add', 'uses' => 'DrivingController@add']);
        //保存驾校数据
        Route::post('/driving_school_save',['as' => 'admin.driving_save', 'uses' => 'DrivingController@save']);
        //删除驾校数据
        Route::get('/driving_school_delete/{info_id?}',['as' => 'admin.driving_delete', 'uses' => 'DrivingController@delete']);

        //二手列表
        Route::get('/secondary_list',['as' => 'admin.secondary_list', 'uses' => 'SecondaryController@index']);
        //添加或者编辑二手
        Route::get('/secondary_add/{secondary_id?}',['as' => 'admin.secondary_add', 'uses' => 'SecondaryController@add']);
        //保存二手数据
        Route::post('/secondary_save',['as' => 'admin.secondary_save', 'uses' => 'SecondaryController@save']);
        //删除二手数据
        Route::get('/secondary_delete/{secondary_id?}',['as' => 'admin.secondary_delete', 'uses' => 'SecondaryController@delete']);
    });

    /**
     * 权限管理
     */
    Route::group(['namespace' => 'Permission'], function () {
        //角色列表
        Route::get('/roles_list',['as' => 'admin.roles_list', 'uses' => 'RolesController@index']);
        //用户所属角色列表
        Route::get('/roles_users',['as' => 'admin.roles_users', 'uses' => 'RolesController@roles_users']);

    });

    /**
     * Other控制器
     */
    //回收站
    Route::get('/recycle_bin',['as' => 'admin.recycle_bin', 'uses' => 'OtherController@recycle_bin']);
    //恢复post
    Route::get('/recover_post/{post_id?}',['as' => 'admin.recover_post', 'uses' => 'OtherController@recover_post']);


});


/*
|--------------------------------------------------------------------------
| API路由
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web'],'prefix' => 'api','namespace' => 'Api'], function () {

    //上传图片api
    Route::post('/photo_add',['as' => 'photo_add', 'uses' => 'FileController@photo_add']);

});
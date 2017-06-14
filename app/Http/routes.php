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

    Route::group(['middleware' => 'web','namespace' => 'Home'], function () {

        //世界
        Route::get('/home', 'HomeController@index');
        Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
        //帖子
        Route::get('/post', ['as' => 'post', 'uses' => 'HomeController@post']);
        //生活
        Route::get('/life', ['as' => 'life', 'uses' => 'HomeController@life']);
        //我的
        Route::get('/mine', ['as' => 'mine', 'uses' => 'HomeController@mine']);
        //post详情页
        Route::get('/details/{id?}', ['as' => 'details', 'uses' => 'HomeController@details']);
        //job详情页
        Route::get('/details_job/{id?}', ['as' => 'details_job', 'uses' => 'HomeController@details_job']);
        //租赁详情页
        Route::get('/details_lease/{id?}', ['as' => 'details_lease', 'uses' => 'HomeController@details_lease']);
        //二手详情页
        Route::get('/details_market/{id?}', ['as' => 'details_market', 'uses' => 'HomeController@details_market']);
        //照片详情页
        Route::get('/details_photo/{id?}', ['as' => 'details_photo', 'uses' => 'HomeController@details_photo']);
        //课程表
        Route::get('/courses_list/{id?}', ['as' => 'courses_list', 'uses' => 'HomeController@courses_list']);
        //课程表查看选择班级
        Route::get('/courses_details/{id?}', ['as' => 'courses_details', 'uses' => 'HomeController@courses_details']);
        //课程表详情
        Route::get('/timetables/{major_id?}/{grade?}/{class?}', ['as' => 'timetables', 'uses' => 'HomeController@timetables']);
        //登录用户才可以访问
        Route::group(['middleware' => ['web','auth']], function () {
            //发表
            Route::get('/publish', ['as' => 'publish', 'uses' => 'HomeController@publish']);
            //个人信息
            Route::get('/personal', ['as' => 'personal', 'uses' => 'HomeController@personal']);
            //我的照片
            Route::get('/my_photo', ['as' => 'my_photo', 'uses' => 'HomeController@my_photo']);
            //修改密码
            Route::get('/password_update_view', ['as' => 'password_update_view', 'uses' => 'HomeController@password_update_view']);
            //修改密码
            Route::post('/password_update', ['as' => 'password_update', 'uses' => 'HomeController@password_update']);
            //我收藏的照片
            Route::get('/my_collect', ['as' => 'my_collect', 'uses' => 'HomeController@my_collect']);

        });
        
    });

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

Route::group(['middleware' => ['web','auth','admin'],'prefix' => 'admin','namespace' => 'Admin'], function () {

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

        //720
        Route::get('/720_list',['as' => 'admin.720_list', 'uses' => 'PanoramaController@index']);
        Route::get('/720_add/{id?}',['as' => 'admin.720_add', 'uses' => 'PanoramaController@add']);
        Route::post('/720_save',['as' => 'admin.720_save', 'uses' => 'PanoramaController@save']);
        
        //二手列表
        Route::get('/secondary_list',['as' => 'admin.secondary_list', 'uses' => 'SecondaryController@index']);
        //添加或者编辑二手
        Route::get('/secondary_add/{secondary_id?}',['as' => 'admin.secondary_add', 'uses' => 'SecondaryController@add']);
        //保存二手数据
        Route::post('/secondary_save',['as' => 'admin.secondary_save', 'uses' => 'SecondaryController@save']);
        //删除二手数据
        Route::get('/secondary_delete/{secondary_id?}',['as' => 'admin.secondary_delete', 'uses' => 'SecondaryController@delete']);

        //课程表
        Route::get('/course_list',['as' => 'admin.course_list', 'uses' => 'CourseController@index']);
        Route::get('/course_add/{id?}',['as' => 'admin.course_add', 'uses' => 'CourseController@course_add']);
        Route::post('/course_save',['as' => 'admin.course_save', 'uses' => 'CourseController@course_save']);
        Route::post('/course_del',['as' => 'admin.course_del', 'uses' => 'CourseController@course_del']);
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
     * 基础数据
     */
    Route::group(['namespace' => 'BasicData'], function () {
        //学校
        Route::get('/school_list',['as' => 'admin.school_list', 'uses' => 'SchoolController@index']);
        Route::get('/school_add/{id?}',['as' => 'admin.school_add', 'uses' => 'SchoolController@school_add']);
        Route::post('/school_save',['as' => 'admin.school_save', 'uses' => 'SchoolController@school_save']);
        //院系
        Route::get('/department_list',['as' => 'admin.department_list', 'uses' => 'SchoolController@department_list']);
        Route::get('/department_add/{id?}',['as' => 'admin.department_add', 'uses' => 'SchoolController@department_add']);
        Route::post('/department_save',['as' => 'admin.department_save', 'uses' => 'SchoolController@department_save']);
        //专业
        Route::get('/major_list',['as' => 'admin.major_list', 'uses' => 'SchoolController@major_list']);
        Route::get('/major_add/{id?}',['as' => 'admin.major_add', 'uses' => 'SchoolController@major_add']);
        Route::post('/major_save',['as' => 'admin.major_save', 'uses' => 'SchoolController@major_save']);
        Route::get('/school_department/{school?}',['as' => 'school_department', 'uses' => 'SchoolController@school_department']);
        Route::get('/department_major/{department?}',['as' => 'department_major', 'uses' => 'SchoolController@department_major']);
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

Route::group(['middleware' => ['web','auth_api'],'prefix' => 'api','namespace' => 'Api'], function () {

    //上传图片api
    Route::post('/photo_add',['as' => 'photo_add', 'uses' => 'FileController@photo_add']);

    //租赁回复api
    Route::post('/lease_comment',['as' => 'comment', 'uses' => 'MobileController@comment']);
    //喜欢租赁api
    Route::post('/lease_love',['as' => 'lease_love', 'uses' => 'MobileController@lease_love']);
    //上传自拍
    Route::post('/photo_upload',['as' => 'photo_upload', 'uses' => 'MobileController@photo_upload']);
    //用户信息修改
    Route::any('/user_edit',['as' => 'user_edit', 'uses' => 'MobileController@user_edit']);
    
});
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });


        $this->setupPermission();
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
    
    
    
    /**
     * 初始化角色和权限
     */
    public function setupPermission() {
        //角色
        $roles = array(
            array('name'=>ROLE_ADMIN, 'display_name'=>'超级管理员', 'description'=>'具有所有权限'),
            array('name'=>ROLE_MANAGER, 'display_name'=>'管理员', 'description'=>'具有大部分权限,但不能编辑和删除用户，也没有权限管理权限'),
        );

        //权限集
        $permissions = array(
            array('name'=>'management_user', 'display_name'=>'管理用户', 'description'=>'可以修改用户或者删除用户'),
            array('name'=>'management_photo', 'display_name'=>'管理照片', 'description'=>'管理用户上传的照片'),
            array('name'=>'management_post', 'display_name'=>'管理文章', 'description'=>'管理文章，post表，驾校、帖子等'),
            array('name'=>'management_job', 'display_name'=>'管理兼职', 'description'=>'管理兼职，对兼职表增删查改'),
            array('name'=>'management_lease', 'display_name'=>'管理租赁', 'description'=>'管理租赁，对租赁表增删查改'),
            array('name'=>'management_table', 'display_name'=>'管理课程表', 'description'=>'管理课程表，对课程表增删查改'),
            array('name'=>'management_secondary', 'display_name'=>'管理二手市场', 'description'=>'管理二手市场，对二手市场表增删查改'),
            array('name'=>'management_permission', 'display_name'=>'管理权限', 'description'=>'管理权限，对权限增删查改'),
        );

        foreach ($roles as $role) {
            $RoleModel = new \App\Model\Role();
            $RoleModel->name = $role['name'];
            $RoleModel->display_name = $role['display_name'];
            $RoleModel->description = $role['description'];
            $RoleModel->save();
        }

        foreach ($permissions as $permission) {
            $PermissionModel = new \App\Model\Permission();
            $PermissionModel->name = $permission['name'];
            $PermissionModel->display_name = $permission['display_name'];
            $PermissionModel->description = $permission['description'];
            $PermissionModel->save();
        }
    }
}

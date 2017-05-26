<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->comment('学校名称');
            $table->string('address', 100)->comment('学校地址');
            $table->string('province', 20)->comment('所在省份');
            $table->text('description')->nullable()->comment('学校介绍');
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->comment('系名称');
            $table->unsignedInteger('school_id')->comment('所属学校');
            $table->text('description')->nullable()->comment('系介绍');
            $table->timestamps();
        });

        Schema::create('majors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->comment('专业名称');
            $table->unsignedInteger('school_id')->comment('所属学校');
            $table->unsignedInteger('department_id')->comment('所属系');
            $table->text('description')->nullable()->comment('专业介绍');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname',20)->comment('昵称');
            $table->string('cellphone', 11)->unique()->comment('手机号');
            $table->string('password', 60);
            $table->string('avatar')->nullable()->comment('头像');
            $table->enum('type',['student','teacher','social','admin'])->default('student')->comment('用户类型');
            $table->string('name',10)->nullable()->comment('姓名');
            $table->string('email',100)->nullable()->comment('邮箱');
            $table->string('qq',20)->nullable()->comment('qq');
            $table->tinyInteger('sex')->default(3)->comment('1男2女3保密');
            $table->string('signature',200)->nullable()->comment('个性签名');
            $table->string('hobby')->nullable()->comment('爱好，多个逗号分隔');
            $table->boolean('active')->default(1)->comment('账号是否激活');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('对应账户id');
            $table->unsignedInteger('school_id')->nullable()->comment('所读学校');
            $table->unsignedInteger('department_id')->nullable()->comment('所在系');
            $table->unsignedInteger('major_id')->nullable()->comment('所读专业');
            $table->string('grade', 10)->nullable()->comment('年级，比如02级');
            $table->string('class', 10)->nullable()->comment('班级，比如1班');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('students');
        Schema::drop('users');
        Schema::drop('majors');
        Schema::drop('departments');
        Schema::drop('schools');
    }
}

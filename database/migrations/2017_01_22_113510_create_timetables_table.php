<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->comment('课程名称');
            $table->string('comment', 200)->nullable()->comment('课程说明');
            $table->unsignedInteger('school_id')->comment('所属学校');
            $table->unsignedInteger('department_id')->comment('所属系');
            $table->unsignedInteger('major_id')->comment('所属专业');

            $table->timestamps();
        });

        Schema::create('timetables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->comment('课程');
            $table->string('grade', 10)->comment('年级，比如02级');
            $table->string('class', 10)->comment('班级，比如1班');
            $table->string('teacher', 10)->nullable()->comment('上课老师');
            $table->text('time_info')->comment('上课时间信息,json字符串');
            $table->tinyInteger('minutes')->nullable()->comment('上课时长，一节课多少分钟');
            $table->tinyInteger('lessons')->nullable()->comment('共多少课时');
            $table->text('comment')->nullable()->comment('备注说明');
            $table->timestamps();
        });

        Schema::create('timetable_details', function (Blueprint $table) {
            $table->unsignedInteger('timetable_id')->comment('课程表');
            $table->dateTime('time')->comment('上课时间');
            $table->tinyInteger('lessons')->nullable()->comment('上几节课');
            $table->string('place', 45)->nullable()->comment('上课地点');
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
        Schema::drop('timetables');
    }
}

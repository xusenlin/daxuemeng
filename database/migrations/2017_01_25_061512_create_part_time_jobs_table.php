<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartTimeJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_time_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',45)->comment('企业名称');
            $table->string('position_type', 45)->comment('职位类别');
            $table->string('salary', 100)->comment('薪资水平');
            $table->string('person_count',45)->comment('招聘人数');
            $table->enum('sex', ['male','female','all'])->comment('性别要求');
            $table->text('position_desc')->comment('职位描述');
            $table->string('work_place', 100)->comment('工作地点');
            $table->string('work_time', 100)->comment('工作时间');
            $table->string('contact', 20)->comment('联系人');
            $table->string('contact_phone', 40)->comment('联系电话');
            $table->string('qq', 20)->nullable()->comment('QQ');
            $table->string('email', 100)->nullable()->comment('邮箱');
            $table->string('comment', 200)->nullable()->comment('备注');
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
        Schema::drop('part_time_jobs');
    }
}

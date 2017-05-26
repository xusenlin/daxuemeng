<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message',100)->nullable()->comment('留言');
            $table->text('photo')->comment('照片');
            $table->unsignedInteger('user_id')->comment('上传用户');
            $table->string('latitude',20)->comment('纬度');
            $table->string('longitude',20)->comment('经度');
            $table->string('place', 50)->comment('发送地点');
            $table->string('province', 20)->comment('省份');
            $table->string('city', 20)->comment('城市');
            $table->integer('view_count')->default(0)->comment('浏览数量');
            $table->integer('comment_count')->default(0)->comment('评论数量');
            $table->integer('favorite_count')->default(0)->comment('点赞数量');
            $table->integer('collect_count')->default(0)->comment('收藏数量');
            $table->timestamps();
        });

        Schema::create('user_photo_flows', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('用户');
            $table->unsignedInteger('photo_id')->comment('照片');
            $table->enum('type',['favorite','collect'])->comment('点赞,收藏');

            $table->timestamps();
        });

        Schema::create('user_photo_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content', 200)->comment('回复内容');
            $table->unsignedInteger('author')->comment('作者');
            $table->unsignedInteger('photo_id')->comment('照片');
            $table->unsignedInteger('reply_to')->nullable()->comment('回复哪条评论');

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
        Schema::drop('user_photo_flows');
        Schema::drop('user_photo_comments');
        Schema::drop('user_photos');
    }
}

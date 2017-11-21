<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->comment('标题');
            $table->longText('content')->nullable()->comment('内容');
            $table->text('excerpt')->nullable()->comment('摘要');
            $table->enum('status',['draft','published','recycled'])->default('draft')->comment('状态');
            $table->string('type', 45)->nullable()->comment('类型');
            $table->integer('category_id')->nullable()->comment('分类id');
            $table->string('tag', 200)->nullable()->comment('标签');
            $table->string('cover')->nullable()->comment('封面');
            $table->dateTime('published_time')->nullable()->comment('发布时间');
            $table->integer('view_count')->default(0)->comment('浏览量');
            $table->integer('comment_count')->default(0)->comment('评论数');
            $table->integer('favorite_count')->default(0)->comment('点赞数');
            $table->integer('collected_count')->default(0)->comment('收藏数');
            $table->integer('forward_count')->default(0)->comment('转发次数');
            $table->boolean('is_top')->default(0)->comment('是否置顶');
            $table->text('meta_data')->nullable()->comment('扩展数据');
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
        Schema::drop('posts');
    }
}

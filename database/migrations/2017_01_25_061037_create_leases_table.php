<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',45)->comment('产品名称');
            $table->string('title', 200)->comment('租赁标题');
            $table->mediumText('description')->nullable()->comment('租赁描述');
            $table->string('tag')->nullable()->comment('标签');
            $table->string('cover')->nullable()->comment('封面图片');
            $table->decimal('unit_price')->comment('租赁单价');
            $table->integer('total_qty')->comment('产品数量');
            $table->integer('sale_qty')->default(0)->comment('已租数量');
            $table->integer('left_qty')->comment('剩余数量');
            $table->enum('status', ['pending','published'])->default('pending')->comment('状态');
            $table->unsignedInteger('owner')->comment('产品所有者');
            $table->string('cellphone', 100)->comment('联系电话,多个逗号分隔');
            $table->text('images')->nullable()->comment('产品图片,多个逗号分隔');
            $table->timestamps();
        });

        Schema::create('user_lease_flows', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('用户');
            $table->unsignedInteger('lease_id')->comment('租赁');
            $table->enum('type',['favorite','collect'])->comment('点赞,收藏');

            $table->timestamps();
        });

        Schema::create('user_lease_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content', 500)->comment('回复内容');
            $table->unsignedInteger('author')->comment('作者');
            $table->unsignedInteger('lease_id')->comment('租赁');
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
        Schema::drop('leases');
    }
}

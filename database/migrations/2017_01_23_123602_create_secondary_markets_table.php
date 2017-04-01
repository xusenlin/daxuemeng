<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondaryMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondary_markets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',45)->comment('产品名称');
            $table->string('title', 100)->comment('出售标题');
            $table->mediumText('description')->nullable()->comment('产品描述');
            $table->string('tag')->nullable()->comment('标签');
            $table->string('cover')->nullable()->comment('封面图片');
            $table->decimal('original_price')->comment('原价单价');
            $table->decimal('sale_price')->comment('售价单价');
            $table->integer('total_qty')->comment('总数量');
            $table->integer('sale_qty')->default(0)->comment('已售数量');
            $table->integer('left_qty')->comment('剩余数量');
            $table->enum('status', ['pending','published'])->default('pending')->comment('状态');
            $table->unsignedInteger('owner')->comment('产品所有者');
            $table->string('cellphone', 100)->comment('联系电话,多个逗号分隔');
            $table->text('images')->nullable()->comment('产品图片,多个逗号分隔');
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
        Schema::drop('secondary_markets');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // These columns are needed for Baum's Nested Set implementation to work.
            // Column names may be changed, but they *must* all exist and be modified
            // in the model.
            // Take a look at the model scaffold comments for details.
            // We add indexes on parent_id, lft, rgt columns by default.
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();
            $table->string('cover')->nullable()->comment('封面图片');
            $table->string('description');
            // Add needed columns here (f.ex: name, slug, path, etc.)

            $table->timestamps();
        });

        $this->initCategories();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }

    /**
     * initCategories
     */
    public function initCategories(){

        \App\Model\Category::create([
            'name' => \App\Model\Category::ROOT_NAME,
            'description' => "分类顶级目录"
        ]);
    }

}

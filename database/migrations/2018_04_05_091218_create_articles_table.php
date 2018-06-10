<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->unsignedInteger('image_id')->comment('图片')->nullable();
            $table->string('description')->comment('描述');
            $table->text('content')->comment('内容');
            $table->string('url')->comment('文章来源')->nullable();
            $table->integer('view_account')->comment('浏览量')->default(0);
            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}

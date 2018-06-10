<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('image_id')->nullable()->comment('作者图片');
            $table->string('author')->comment('作者名称');
            $table->string('author_description')->comment('作者简介');
            $table->string('site_description')->comment('网站简介');
            $table->integer('is_comment')->comment('是否允许评论')->default(1);
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
        Schema::dropIfExists('sites');
    }
}

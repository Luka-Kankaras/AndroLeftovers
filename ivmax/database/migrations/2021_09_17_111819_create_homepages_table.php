<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_info', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('photo_or_video');
            $table->string('video_name');
            $table->string('video_ext');
            $table->string('thumbnail_big');
            $table->string('thumbnail_small');
            $table->text('text_1')->nullable();
            $table->text('text_2')->nullable();
            $table->text('feature_1')->nullable();
            $table->text('feature_2')->nullable();
            $table->text('feature_3')->nullable();
            $table->text('feature_4')->nullable();
            $table->text('ivmax_anatomy');
            $table->text('annual_text_1')->nullable();
            $table->text('annual_text_2')->nullable();
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
        Schema::dropIfExists('homepages');
    }
}

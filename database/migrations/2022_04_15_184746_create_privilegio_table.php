<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privilegio', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->tinyInteger('status')->default('1');
            $table->text('description')->nullable(); 
            $table->tinyInteger('is_visible')->default('1');
            $table->tinyInteger('is_report')->default('1');
            $table->integer('order')->default('0');
            $table->string('url');
            $table->string('icon')->nullable(); 
            $table->string('class')->nullable(); 
            $table->string('method')->nullable(); 
            $table->string('post_method')->nullable(); 
            $table->tinyInteger('request_post')->default('0');
            $table->tinyInteger('request_get')->default('0');
            $table->tinyInteger('is_menu')->default('0');
            $table->tinyInteger('read')->default('1');
            $table->tinyInteger('write')->default('1');
            $table->tinyInteger('update')->default('1');
            $table->tinyInteger('delete')->default('1');
            $table->tinyInteger('upload')->default('1');
            $table->tinyInteger('download')->default('1');
            $table->tinyInteger('export')->default('1');
            $table->tinyInteger('send_email')->default('1');
            $table->integer('asigned')->default('0');
            $table->integer('parent');
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
        Schema::dropIfExists('privilegio');
    }
};

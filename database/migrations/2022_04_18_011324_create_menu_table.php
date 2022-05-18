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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('label')->nullable(); 
            $table->tinyInteger('status')->default('1'); 
            $table->tinyInteger('is_text')->default('1'); 
            $table->string('icon')->nullable();
            $table->string('class')->nullable();
            $table->string('color')->nullable();
            $table->integer('parent')->default('1');
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
        Schema::dropIfExists('menu');
    }
};

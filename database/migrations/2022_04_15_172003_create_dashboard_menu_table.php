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
        Schema::create('dashboard_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->tinyInteger('status')->default('1');
            $table->string('icon')->nullable(); 
            $table->string('class')->nullable(); 
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
        Schema::dropIfExists('dashboard_menu');
    }
};

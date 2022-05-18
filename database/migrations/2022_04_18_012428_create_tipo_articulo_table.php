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
        Schema::create('tipo_articulo', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->tinyInteger('status')->default('1');   
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
        Schema::dropIfExists('tipo_articulo');
    }
};

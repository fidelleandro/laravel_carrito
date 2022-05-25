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
        Schema::create('rol', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->tinyInteger('status')->default('1'); 
            $table->tinyInteger('is_ceo')->default('0');
            $table->tinyInteger('is_visible')->default('1'); 
            $table->text('description')->nullable(); 
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
        Schema::dropIfExists('rol_priv');
    }
};

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
        Schema::create('rol_priv', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rol_id')->unsigned(); 
            $table->bigInteger('privilegio_id')->unsigned(); 
            $table->tinyInteger('is_visible')->default('1');
            $table->tinyInteger('status')->default('1'); 
            $table->tinyInteger('read')->default('1');
            $table->tinyInteger('write')->default('1');
            $table->tinyInteger('update')->default('1');
            $table->tinyInteger('delete')->default('1');
            $table->tinyInteger('upload')->default('1');
            $table->tinyInteger('download')->default('1');
            $table->tinyInteger('export')->default('1');
            $table->tinyInteger('send_email')->default('1');
            $table->timestamps();
            $table->foreign('rol_id')
                       ->references('id')
                       ->on('rol')
                       ->onCascade('delete');
                       
            $table->foreign('privilegio_id')
                        ->references('id')
                        ->on('privilegio')
                        ->onCascade('delete');  
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

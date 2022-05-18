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
        Schema::create('articulo', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('tipo_articulo_id')->unsigned();  
            $table->string('url');
            $table->longText('info');
            $table->text('keywords');
            $table->tinyInteger('status')->default('1');   
            $table->text('resumen')->nullable();
            $table->integer('parent')->default('0');
            $table->timestamps();
            $table->foreign('tipo_articulo_id')
                       ->references('id')
                       ->on('tipo_articulo')
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
        Schema::dropIfExists('articulo');
    }
};

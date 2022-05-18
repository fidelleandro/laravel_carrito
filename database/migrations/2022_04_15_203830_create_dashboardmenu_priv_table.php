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
        Schema::create('dashboardmenu_priv', function (Blueprint $table) {
            $table->id(); 
            $table->bigInteger('dashboardmenu_id')->unsigned(); 
            $table->bigInteger('privilegio_id')->unsigned(); 
            $table->timestamps();
            
            $table->foreign('dashboardmenu_id')
                       ->references('id')
                       ->on('dashboard_menu')
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
        Schema::dropIfExists('dashboardmenu_priv');
    }
};

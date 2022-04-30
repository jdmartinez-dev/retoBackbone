<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->integer('key');  # id_asenta_cpcons
            $table->string('name'); # d_asenta
            $table->string('zone_type'); # d_zona
            $table->bigInteger('zipcode_id'); # d_codigo
            $table->bigInteger('settlement_type_id'); # c_tipo_asenta

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlements');
    }
}





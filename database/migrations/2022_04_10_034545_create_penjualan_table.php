<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->integer("iduser");
            $table->integer("idpelangan");
            $table->dateTime("tgl");
            $table->string("nofaktur", 20);
            $table->decimal("bayar", 30, 2);
            $table->decimal("kembali", 30, 2);
            $table->integer("idpelangan");
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
        Schema::dropIfExists('penjualan');
    }
}

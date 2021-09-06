<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klasifikasi_id');
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('nomor_berkas');
            $table->string('jenis_berkas');
            $table->string('file');
            $table->text('uraian_informasi');
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
        Schema::dropIfExists('berkas');
    }
}

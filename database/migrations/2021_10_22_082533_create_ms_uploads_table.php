<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_uploads', function (Blueprint $table) {
            $table->id();
            $table->Integer('pid')->comment('Relasi dengan Person');
            $table->string('desc')->comment('Keterangan');
            $table->string('url')->comment('URL untuk diakses');
            $table->string('original_file')->comment('Lokasi File Original');
            $table->Integer('cby');
            $table->Integer('uby');
            $table->timestamp('con');
            $table->timestamp('uon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_uploads');
    }
}

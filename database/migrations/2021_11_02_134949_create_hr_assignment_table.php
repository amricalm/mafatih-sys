<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_assignment', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama Tugas Pokok dan Fungsi');
            $table->string('name_ar')->comment('Jika ada nama arab untuk tupoksi');
            $table->text('desc')->comment('Deskripsi Tupoksi');
            $table->integer('cby');
            $table->integer('uby');
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
        Schema::dropIfExists('hr_assignment');
    }
}

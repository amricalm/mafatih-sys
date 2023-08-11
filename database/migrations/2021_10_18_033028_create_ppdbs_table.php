<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpdbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aa_ppdb', function (Blueprint $table) {
            $table->id();
            $table->Integer('person_id')->comment('Relasi dengan Person');
            $table->Integer('school_id')->comment('Relasi dengan School');
            $table->Integer('academic_year_id')->comment('Relasi dengan Academic Year');
            $table->Integer('cby')->comment('Created By');
            $table->Integer('uby')->comment('Updated By');
            $table->timestamp('con')->comment('Created On');
            $table->timestamp('uon')->comment('Updated On');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppdbs');
    }
}

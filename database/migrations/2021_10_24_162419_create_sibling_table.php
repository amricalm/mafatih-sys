<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiblingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aa_sibling', function (Blueprint $table) {
            $table->id();
            $table->integer('pid')->comment('Person Id');
            $table->integer('sid')->comment('Ini untuk Person Id Siblingnya');
            $table->integer('cby')->default(0);
            $table->integer('uby')->default(0);
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
        Schema::dropIfExists('aa_sibling');
    }
}

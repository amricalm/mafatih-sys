<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aa_achievement', function (Blueprint $table) {
            $table->id();
            $table->integer('pid');
            $table->string('name');
            $table->integer('year');
            $table->string('desc');
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
        Schema::dropIfExists('aa_achievement');
    }
}

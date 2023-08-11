<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToAaPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aa_person', function (Blueprint $table) {
            $table->Integer('ayah_id')->after('user_id')->comment('Relasi dengan Person untuk Ayah');
            $table->Integer('ibu_id')->after('ayah_id')->comment('Relasi dengan Person untuk Ayah');
            $table->Integer('wali_id')->after('ibu_id')->comment('Relasi dengan Person untuk Ayah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aa_person', function (Blueprint $table) {
            $table->dropColumn('ayah_id');
            $table->dropColumn('ayah_id');
            $table->dropColumn('wali_id');
        });
    }
}

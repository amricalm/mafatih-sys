<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompleteToAaPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aa_person', function (Blueprint $table) {
            $table->string('nickname')->after('name')->comment('Nama Panggilan');
            $table->tinyInteger('son_order')->after('dob')->comment('Anak ke');
            $table->tinyInteger('siblings')->after('son_order')->comment('Jumlah Saudara kandung');
            $table->tinyInteger('stepbros')->after('siblings')->comment('Jumlah Saudara Tiri');
            $table->tinyInteger('adoptives')->after('stepbros')->comment('Jumlah Saudara Angkat');
            $table->String('citizen')->after('adoptives')->comment('Kewarganegaraan');
            $table->String('religion')->after('citizen')->comment('Agama');
            $table->String('languages')->after('religion')->comment('Bahasa');
            $table->Integer('user_id')->after('languages')->comment('Relasi dengan User');
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
            $table->dropColumn('nickname');
            $table->dropColumn('son_order');
            $table->dropColumn('siblings');
            $table->dropColumn('stepbros');
            $table->dropColumn('adoptives');
            $table->dropColumn('citizen');
            $table->dropColumn('religion');
            $table->dropColumn('languages');
            $table->dropColumn('user_id');
        });
    }
}

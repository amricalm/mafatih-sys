<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgeToAaPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aa_person', function (Blueprint $table) {
            $table->Integer('age')->after('wali_id')->comment('Umur');
            $table->string('job')->after('age')->comment('Pekerjaan');
            $table->string('last_education')->after('job')->comment('Pendidikan Terakhir');
            $table->decimal('income',12,2)->after('last_education')->comment('Penghasilan');
            $table->Integer('stay_with_parent')->default('1')->after('last_education')->comment('Penghasilan');
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
            //
        });
    }
}

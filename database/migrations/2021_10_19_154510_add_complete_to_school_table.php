<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompleteToSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aa_school', function (Blueprint $table) {
            $table->string('nss')->after('institution_id')->nullable()->comment('Nomor Statistik Sekolah');
            $table->string('year')->after('name')->nullable()->comment('Tahun Berdiri Sekolah');
            $table->string('accreditation')->after('school_type_id')->nullable()->comment('Status Akreditasi');
            $table->string('phone')->after('accreditation')->nullable()->comment('Nomor Telpon Sekolah');
            $table->string('email')->after('phone')->nullable()->comment('Email Sekolah');
            $table->string('surface_area')->after('email')->nullable()->comment('Luas Tanah');
            $table->string('building_area')->after('surface_area')->nullable()->comment('Luas Bangunan');
            $table->string('land_status')->after('building_area')->nullable()->comment('Status Tanah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aa_school', function (Blueprint $table) {
            $table->dropColumn('nss');
            $table->dropColumn('year');
            $table->dropColumn('accreditation');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('surface_area');
            $table->dropColumn('building_area');
            $table->dropColumn('land_status');
        });
    }
}

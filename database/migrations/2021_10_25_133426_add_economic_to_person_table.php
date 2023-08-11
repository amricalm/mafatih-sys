<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEconomicToPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aa_person', function (Blueprint $table) {
            $table->string('building_status')->after('hobbies')->nullable()->comment('Status Rumah');
            $table->string('surface_area')->after('building_status')->nullable()->comment('Luas Tanah');
            $table->string('building_area')->after('surface_area')->nullable()->comment('Luas Bangunan');
            $table->decimal('electricity_bills',12,2)->after('building_area')->nullable()->comment('Tagihan Listrik');
            $table->decimal('water_bills',12,2)->after('electricity_bills')->nullable()->comment('Tagihan PDAM');
            $table->decimal('telecommunication_bills',12,2)->after('water_bills')->nullable()->comment('Tagihan Telkom');
            $table->text('electronic')->after('telecommunication_bills')->nullable()->comment('Alat Elektronik');
            $table->text('vehicle')->after('electronic')->nullable()->comment('Semua Kendaraan');
            $table->text('assets')->after('vehicle')->nullable()->comment('Semua Aset');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('person', function (Blueprint $table) {
            $table->dropColumn('building_status');
            $table->dropColumn('surface_area');
            $table->dropColumn('building_area');
            $table->dropColumn('electricity_bills');
            $table->dropColumn('water_bills');
            $table->dropColumn('telecommunication_bills');
            $table->dropColumn('electronic');
            $table->dropColumn('vehicle');
            $table->dropColumn('assets');
        });
    }
}

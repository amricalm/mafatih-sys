<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAaAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aa_address', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->comment('Relasi dengan Tabel Lain');
            $table->string('type')->default('person,school');
            $table->text('address')->comment('Alamat Lengkap');
            $table->Integer('province')->comment('Provinsi');
            $table->Integer('city')->comment('Kota/Kabupaten');
            $table->Integer('district')->comment('Kecamatan');
            $table->Integer('village')->comment('Desa');
            $table->Integer('post_code')->comment('Kode Pos');
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
        Schema::dropIfExists('aa_address');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeightToPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aa_person', function (Blueprint $table) {
            $table->integer('height')->after('stay_with_parent')->default('0')->comment('Tinggi Badan');
            $table->integer('weight')->after('height')->default('0')->comment('Berat Badan');
            $table->integer('is_glasses')->after('weight')->default('0')->comment('Berkacamata atau tidak');
            $table->string('character')->after('is_glasses')->nullable()->comment('Karakter');
            $table->string('hobbies')->after('character')->nullable()->comment('Hobi');
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
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('is_glasses');
            $table->dropColumn('character');
            $table->dropColumn('hobbies');
        });
    }
}

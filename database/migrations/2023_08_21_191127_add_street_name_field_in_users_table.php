<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStreetNameFieldInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('zip_code')->nullable();
            $table->string('street_name')->nullable();
            $table->integer('street_number')->nullable();
            $table->string('neigborhood')->nullable();
            $table->string('complement')->nullable();
            $table->string('city')->nullable();
            $table->string('federal_unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('zip_code');
            $table->dropColumn('street_name');
            $table->dropColumn('street_number');
            $table->dropColumn('neigborhood');
            $table->dropColumn('complement');
            $table->dropColumn('city');
            $table->dropColumn('federal_unit');
        });
    }
}

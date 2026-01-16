<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('addresses.models.googleAddress.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('postal_code', 16)->nullable();
            $table->string('street_number', 16)->nullable();
            $table->string('route', 64)->nullable();


            $table->string('locality', 64)->nullable();
            $table->string('administrative_area_level_3', 64)->nullable();
            $table->string('administrative_area_level_2', 64)->nullable();
            $table->string('administrative_area_level_2_short', 4)->nullable();

            $table->string('administrative_area_level_1', 64)->nullable();
            $table->string('country', 64)->nullable();
            $table->string('country_short', 4)->nullable();

            $table->decimal('navigation_point_latitude', 10, 7)->nullable();
            $table->decimal('navigation_point_longitude', 10, 7)->nullable();

            $table->string('place_id', 256)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('addresses.models.googleAddress.table'));
    }
};

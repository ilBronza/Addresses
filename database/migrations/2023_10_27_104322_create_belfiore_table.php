<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('addresses.models.region.table'), function (Blueprint $table) {
            $table->string('slug')->primary();
            $table->string('name');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('addresses.models.province.table'), function (Blueprint $table) {
            $table->string('slug')->primary();
            $table->string('name');
            $table->string('region_slug')->nullable();
            $table->foreign('region_slug')->references('slug')->on(config('addresses.models.region.table'));

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(config('addresses.models.city.table'), function (Blueprint $table) {
            $table->string('slug')->primary();

            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('belfiore', 5)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('istat_code', 10)->nullable();
            $table->string('inps_code', 10)->nullable();
            $table->string('phone_prefix', 10)->nullable();

            $table->string('province_slug')->nullable();
            $table->foreign('province_slug')->references('slug')->on(config('addresses.models.province.table'));

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('addresses.models.city.table'));
        Schema::dropIfExists(config('addresses.models.province.table'));
        Schema::dropIfExists(config('addresses.models.region.table'));
    }
};

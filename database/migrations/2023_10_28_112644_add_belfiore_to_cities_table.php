<?php

use IlBronza\Addresses\Models\City;
use IlBronza\Addresses\Models\Province;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\IOFactory;

return new class extends Migration
{
    public function up(): void
    {
	    Schema::table(City::getProjectClassName()::make()->getTable(), function (Blueprint $table) {
		    $table->unique('belfiore');
	    });


	    Schema::table('addresses', function (Blueprint $table) {
			$table->string('belfiore', 5)->after('city')->nullable();
			$table->foreign('belfiore')->references('belfiore')->on(config('addresses.models.city.table'));
	    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
	    Schema::table('addresses', function (Blueprint $table) {
			$table->dropForeign(['belfiore']);
			$table->dropColumn('belfiore');
	    });

    }
};

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
		$result = DB::table(City::getProjectClassName()::make()->getTable())
		            ->select('belfiore', DB::raw('count(*) as counted'))
		            ->groupBy('belfiore')
		            ->having('counted', '>', 1)
		            ->get();

		foreach($result as $_result)
		{
			$cities = City::where('belfiore', $_result->belfiore)->orderBY('slug')->get();

			if($cities->first()->name == $cities->last()->name)
				$cities->last()->forceDelete();
			else
			{
				if(in_array($cities->first()->name, ['Albaredo']))
					$cities->last()->forceDelete();

				elseif(in_array($cities->first()->name, ['Mure']))
					$cities->first()->forceDelete();

				elseif(in_array($cities->last()->name, ['Islanda']))
					$cities->last()->forceDelete();

				else
				{
					$similarity = similar_text($cities->first()->name, $cities->last()->name, $percent);

					dd([$cities->first()->belfiore, $cities->first()->name, $cities->last()->name, $similarity, $percent]);
				}
			}
		}

	    $result = DB::table(City::getProjectClassName()::make()->getTable())
	                ->select('belfiore', DB::raw('count(*) as counted'))
	                ->groupBy('belfiore')
	                ->having('counted', '>', 1)
	                ->get();

		if(count($result) > 0)
			dd('ripeti');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};

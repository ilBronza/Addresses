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
    public function getProvince(array $row) : ? Province
    {
        if(! $row['I'])
            return null;

        if($province = Province::findCached($row['I']))
            return $province;

        $province = Province::make();
        $province->name = ucwords(strtolower($row['C']));
        $province->slug = strtolower((($row['I'] != "__")&&($row['I'] != "_")&&($row['I'] != "")&&($row['I'] != " "))? $row['I'] : $province->name);
        $province->save();

        return $province;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        cache()->flush();
        DB::table(City::getProjectClassName()::make()->getTable());

        $rows = cache()->remember(
            'belfiorerows',
            1200,
            function()
            {
                $path = str_replace("migrations", "", dirname(__FILE__));
                $csvFile = IOFactory::load($path . 'seeders/belfiore.xlsx');

                return $csvFile->getActiveSheet()->toArray(null, true, true, true);
            }
        );

        $intestation = array_shift($rows);
        $intestation = array_shift($rows);

        foreach($rows as $row)
        {
            $province = $this->getProvince($row);

            $city = City::make();
            $city->name = ucwords(strtolower($row['D']));
            $city->province_slug = $province?->getKey();
            $city->belfiore = $row['B'];
            $city->istat_code = $row['E'];
            $city->inps_code = $row['F'];
            $city->zip = $row['G'];
            $city->phone_prefix = $row['H'];
            $city->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};

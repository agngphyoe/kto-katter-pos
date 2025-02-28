<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LocationType;
use Illuminate\Support\Str;

class LocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locationTypes = [
            'Store',
            'Branch',
            'Office'
        ];

        foreach ($locationTypes as $locationType) {
            $country = LocationType::create([
                'location_type_name' => $locationType,
                'location_counts' => 0,
                'sale_type' => $locationType,
                'created_by' => 1,
            ]);
        }
    }
}

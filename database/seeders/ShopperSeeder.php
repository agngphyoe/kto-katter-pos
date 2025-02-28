<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShopperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Shopper::Create([
            'name' => 'POSCustomer',
            'code' => 'SID-000000',
            'phone' => '000000000',
            'address' => 'Yangon',
        ]);
    }
}

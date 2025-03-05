<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CashBookSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(LocationTypeSeeder::class);
        $this->call(ShopperSeeder::class);
        $this->call(FOCSeeder::class);
        // $this->call(ADDPOSReceivableSeeder::class);
    }
}

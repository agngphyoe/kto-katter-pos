<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductModel;

class FOCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create([
            'name' => 'FOC',
            'slug' => 'foc',
            'created_by' => 1
        ]);

        $brand = Brand::create([
            'name' => 'FOC',
            'category_id' => $category->id,
            'slug' => 'foc',
            'created_by' => 1
        ]);

        $productModel = ProductModel::create([
            'name' => 'FOC',
            'brand_id' => $brand->id,
            'slug' => 'foc',
            'created_by' => 1
        ]);
    }
}

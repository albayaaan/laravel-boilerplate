<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 10; $i++) {
            DB::table('products')->insert([
                'product_name' => "Lorem Ipsum",
                'product_code' => $faker->word,
                'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 100000, $max = NULL),
            ]);
        }
    }
}

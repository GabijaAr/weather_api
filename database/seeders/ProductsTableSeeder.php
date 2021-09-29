<?php

namespace Database\Seeders;

use App\Models\Product;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,150) as $index)  {
            DB::table('products')->insert([
                'recommendations_id'=> $faker->numberBetween($min = 1, $max = 12),
                'sku' => $faker->bothify('??###'),
                'name' => $faker->words($nb = 2, $asText = true),
                'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 1000),
                'created_at' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
            ]);
        }
    }
}

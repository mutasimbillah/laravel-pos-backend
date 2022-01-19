<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run()
    {
        //
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Product::query()->create([
                'name' => $faker->sentence(),
                'price' => rand(30, 40) * 10,
                'stock' => rand(10, 20),
                'details' => $faker->paragraph(1),
            ]);
        }
    }
}

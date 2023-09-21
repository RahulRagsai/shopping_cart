<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Macbook Pro',
            'description' => 'Macbook Pro is a B2B Product',
            'type' => 1,
            'price' => 2000,
        ]);

        Product::create([
            'name' => 'IPhone 14 Pro',
            'description' => 'IPhone Pro is a B2C Product',
            'type' => 2,
            'price' => 2100,
        ]);
    }
}

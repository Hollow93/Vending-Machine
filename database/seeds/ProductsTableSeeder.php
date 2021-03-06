<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([

            [
                'name' => 'Сок',
                'amount' => 15,
                'price' => 35,
                'image_url' => 'images/juice.jpg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Кофе с молоком',
                'amount' => 20,
                'price' => 21,
                'image_url' => 'images/coffee_with_milk.png',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Кофе',
                'amount' => 20,
                'price' => 18,
                'image_url' => 'images/coffee.jpg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Чай',
                'amount' => 10,
                'price' => 13,
                'image_url' => 'images/tea.jpg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],

        ]);
    }
}

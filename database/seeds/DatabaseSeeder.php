<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ClientMoneyTableSeeder::class);
        $this->call(VendingMachineMoneyTableSeeder::class);
        $this->call(CurrentBalancesTableSeeder::class);
    }
}

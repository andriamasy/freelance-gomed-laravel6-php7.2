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
        // $this->call(PaymentsTableSeeder::class);
        // $this->call(PagesSeeder::class);
        $this->call(CredsPayementSeeder::class);
        $this->call(UserSeeder::class);
    }
}
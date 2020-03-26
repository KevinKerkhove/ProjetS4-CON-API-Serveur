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
        $this->call(PlayerTableSeeder::class);
        $this->call(PartieTableSeeder::class);
        $this->call(PlayerPartieTableSeeder::class);
//        $this->call(SuiviTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}

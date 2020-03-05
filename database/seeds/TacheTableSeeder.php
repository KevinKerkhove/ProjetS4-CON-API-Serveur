<?php

use App\Modeles\Partie;
use Illuminate\Database\Seeder;

class TacheTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Partie::class, 20)->create();
    }
}

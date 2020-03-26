<?php

use App\Model\Partie;
use Illuminate\Database\Seeder;

class PartieTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Partie::class, 20)->create();
    }
}

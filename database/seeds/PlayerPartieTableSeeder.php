<?php

use App\Model\Partie;
use App\Modeles\Player;
use Illuminate\Database\Seeder;

class PlayerPartieTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $parties = Partie::all();
        $players_id = Player::all('id')->pluck('id')->toArray();
        $faker = Faker\Factory::create('fr_FR');

        foreach ($parties as $partie) {
            $nbPersonnes = $faker->numberBetween($min = 1, $max = 10);
            $id_personnes = $faker->unique()
                ->randomElements($personnes_id, $nbPersonnes);
            $tache->personnes()->attach($id_personnes);
            $tache->save();
        }
    }
}

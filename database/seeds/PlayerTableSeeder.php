<?php

use App\Model\Personne;
use App\Model\Role;
use App\Modeles\Player;
use App\User;
use Illuminate\Database\Seeder;

class PlayerTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create('fr_FR');
        $players = factory(Player::class, 10)->make()
            ->each(function ($player) use ($faker) {
                $user = factory(User::class)->create([
                    'name' => $player->prenom . ' ' . $player->nom,
                    'email' => $player->prenom . '.' . $player->nom . '@' . $faker->randomElement(['domain.fr', 'gmail.com', 'hotmail.com', 'truc.com', 'machin.fr']),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ])/*->each(function ($user) {

                })*/;
                $user->role()->save(factory(Role::class)->make());
                $player->user_id = $user->id;
                $player->save();
            });
        // Robert Duchmol : joueur
        $user  = factory(User::class)->create([
            'name' => 'Robert Duchmol',
            'email' => 'robert.duchmol@domain.fr',
            'password' => '$2y$10$UFYqX8c1aRFtvZ6AdlV17uesbirEwrRpCz1/fKmFZL2PXSyiHqoG2', // secret
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->role()->save(factory(Role::class)->make(['user_id' => $user->id, 'role' => 'player']));
        $player = factory(Player::class)->make([
            'nom' => 'Duchmol',
            'prenom' => 'Robert',
            'playTime' => '9:7:2',
            'bestScore' => 89778,
        ]);
        $player->user_id = $user->id;
        $player->save();
        // Gollum : admin
        $user = factory(User::class)->create([
            'name' => 'Gollum',
            'email' => 'gollum@domain.fr',
            'password' => '$2y$10$UFYqX8c1aRFtvZ6AdlV17uesbirEwrRpCz1/fKmFZL2PXSyiHqoG2', // secret
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->role()->save(factory(Role::class)->make(['user_id' => $user->id, 'role' => 'admin']));
        $player = factory(Player::class)->make([
            'nom' => 'Smeagol',
            'prenom' => '',
            'playTime' => '1:9:2',
            'bestScore' => 8278,
            'avatar' => 'avatars/gollum.jpeg',
        ]);
        $player->user_id = $user->id;
        $player->save();
    }
}

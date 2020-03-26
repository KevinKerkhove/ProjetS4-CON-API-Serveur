<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modeles\Player;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome() {
        $bestPlayers = Player::where('bestScore', '!=', null)->orderBy('bestScore', 'desc')->take(10)->get();

        return view('welcome', ['bestPlayers' => $bestPlayers]);
    }
}

<?php

namespace App\Model;

use App\Modeles\Player;
use Illuminate\Database\Eloquent\Model;

class Partie extends Model {
    /* OLD
    function suivis() {
        return $this->hasMany(Suivi::class);
    }
    */

    function player() {
        return $this->belongsTo(Player::class);
    }
}

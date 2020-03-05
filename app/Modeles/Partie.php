<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model {
    function player() {
        return $this->belongsTo(Player::class);
    }


}

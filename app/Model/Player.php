<?php

namespace App\Modeles;

use App\Model\Partie;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Player extends Model {
    function parties() {
        return $this->hasMany(Partie::class);
    }

    function user() {
        return $this->belongsTo(User::class);
    }
}

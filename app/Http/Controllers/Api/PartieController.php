<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modeles\Partie;
use Illuminate\Http\Request;

class PartieController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['score','time','ennemiesKilled','id']);

        $partie = new Partie();

        $partie -> score = $input['score'];
        $partie -> time = $input['time'];
        $partie -> ennemiesKilled = $input['ennemiesKilled'];
        $partie-> player_id = $input['id'];


        $partie->save();
    }
}

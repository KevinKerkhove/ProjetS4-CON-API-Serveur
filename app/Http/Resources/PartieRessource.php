<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PartieResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'score' => $this->score,
            'time' => $this->time,
            'ennemiesKilled' => $this->ennemiesKilled,
            'player_id' => $this->player_id,
        ];
    }
}
<?php

namespace App\Http\Resources;

use App\Model\Partie;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PlayerResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        if ($this->avatar == null)
            $path = 'avatars/anonymous.png';
        else
            $path = $this->avatar;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'totalPlayTime' => $this->totalPlayTime,
            'bestScore' => $this->bestScore,
            'avatar'  => url(Storage::url($path)),
            'parties' => Partie::where('player_id',$this->id),
            'user' => new UserResource($this->user),
        ];
    }
}

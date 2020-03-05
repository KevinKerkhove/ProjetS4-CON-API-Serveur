<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PersonneResource extends JsonResource {
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
            'playTime' => $this->playTime,
            'username' => $this->username,
            'bestScore' => $this->bestScore,
            'user_id' => $this->user_id,

            'specialite' => $this->specialite,
            'actif' => $this->actif,
            'avatar'  => url(Storage::url($path)),
            'user' => $this->user,
        ];
    }
}

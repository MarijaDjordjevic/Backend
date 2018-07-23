<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MoveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'game_id' => $this->game_id,
            'player_id' => $this->player_id,
            'position' => $this->position,
            'field_type' => $this->field_type
        ];
    }
}

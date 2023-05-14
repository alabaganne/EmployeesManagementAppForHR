<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) // must be useed on skill table
    {
        return [
            'id' => $this->id, // skill_id
            'name' => $this->name,
            'note' => $this->pivot->note,
        ];
    }
}

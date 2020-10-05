<?php

namespace App\Http\Resources;

use App\Http\Resources\PermissionResource;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = $this->getRoleNames()->first() ? $this->getRoleNames()->first() : 'Employee';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $role,
            'image_path' => $this->image_path,
            'permissions' => PermissionResource::collection($this->getAllPermissions())
        ];
    }
}

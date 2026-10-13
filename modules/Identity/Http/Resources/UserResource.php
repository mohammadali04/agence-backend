<?php

namespace Modules\Identity\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;
use modules\Permission\Http\Resources\RoleResource;

class UserResource extends JsonResource
{
    public function toArray($request){
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'roles' => RoleResource::collection($this->roles)
        ];
    }

}

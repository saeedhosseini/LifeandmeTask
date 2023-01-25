<?php

namespace App\Http\Resources\Panel\V1;

use App\Http\Resources\LifeandmeResourceJson;
use App\Models\User\User;

/**
 * @mixin User
 */
class UserResource extends LifeandmeResourceJson
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birth_day' => $this->birth_day,
            'age' => $this->age,
            'created_at' => $this->created_at,
        ];
    }

}

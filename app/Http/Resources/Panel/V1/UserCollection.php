<?php

namespace App\Http\Resources\Panel\V1;

use App\Http\Resources\LifeandmeResourceCollection;
use App\Models\User\User;

/**
 * @see User
 */
class UserCollection extends LifeandmeResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map(fn($user)=> [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'birth_day' => $user->birth_day,
            'age' => $user->age,
        ]);
    }

}

<?php

namespace App\Http\Resources\Panel\V1;

use App\Http\Resources\LifeandmeResourceJson;
use App\Models\Admin\Admin;

/**
 * @mixin Admin
 */
class AdminResource extends LifeandmeResourceJson
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ];
    }

}

<?php

namespace App\Repositories;

use App\Models\Admin\Admin;
use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class AdminRepositories
{
    public function findWithEmail(string $email){
        return Admin::query()->where('email' , $email)->first();
    }



}

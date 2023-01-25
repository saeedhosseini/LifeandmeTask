<?php

namespace App\Repositories;

use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class UserRepositories
{

    public function paginated(): LengthAwarePaginator|\Illuminate\Pagination\LengthAwarePaginator|array
    {
       return User::query()->paginate();
    }

    /**
     *
     * insert new row in users table
     *
     * @param array $data
     * @throws QueryException
     * @return User|Builder
     */
    public function store(array $data) : User|Builder
    {
        return User::query()->create($data);
    }

    public function find(int $id): Model|Collection|Builder|User|array|null
    {
       return User::query()->findOrFail($id);
    }

    /**
     *
     * update existing row in users table
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user ,array $data) : bool
    {
        return $user->update($data);
    }

    public function remove(User $user) : bool|null
    {
        return $user->delete();
    }

}

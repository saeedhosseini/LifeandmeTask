<?php

namespace App\Http\Services;

use App\Http\Resources\Panel\V1\UserCollection;
use App\Http\Resources\Panel\V1\UserResource;
use App\Repositories\UserRepositories;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserService
{

    private UserRepositories $repositories;

    public function __construct(UserRepositories $repositories)
    {
        $this->repositories = $repositories;
    }

    public function list(): UserCollection
    {
        $users = $this->repositories->paginated();
        return new UserCollection($users);
    }

    public function add(array $data): JsonResponse
    {
        //Hash password
        $data['password'] = Hash::make($data['password']);
        //add by admin is validated user so emailVerification is this time
        $data['email_verified_at'] = now();
        try {
            $this->repositories->store($data);
            return successResponse(true, message: __('crud.store', ['item' => __('models.user')]));
        } catch (QueryException $exception) {
            return errorResponse(__('exceptions.try_again'), exception: $exception);
        }

    }

    public function find($id) : JsonResponse|UserResource
    {
        try {
            $user = $this->repositories->find((int)$id);
            return new UserResource($user);
        } catch (ModelNotFoundException $exception) {
            return errorResponse(__('exceptions.404', ['model' => __('models.user')]), exception: $exception);
        } catch (Exception $exception) {
            return errorResponse(__('exceptions.try_again'), exception: $exception);
        }
    }

    public function edit($id, array $data): JsonResponse
    {
        try {
            $user = $this->repositories->find((int)$id);
            if (array_key_exists('password' , $data) && $data['password'] != null){
                $data['password'] = Hash::make($data['password']);
            }else{
                $data['password'] = $user->password;
            }
            $result = $this->repositories->update($user, $data);
            if ($result)
                return successResponse(true, message: __('crud.update', ['item' => __('models.user')]));
            else
                return errorResponse(__('exceptions.try_again'), type: 'return_update', errorMessage: 'Update Query Returned False');
        } catch (ModelNotFoundException $exception) {
            return errorResponse(__('exceptions.404', ['model' => __('models.user')]), exception: $exception);
        } catch (Exception $exception) {
            return errorResponse(__('exceptions.try_again'), exception: $exception);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $user = $this->repositories->find((int)$id);
            $result = $this->repositories->remove($user);
            if ($result)
                return successResponse(true, message: __('crud.update', ['item' => __('models.user')]));
            else
                return errorResponse(__('exceptions.try_again'), type: 'return_update', errorMessage: 'Update Query Returned False');
        } catch (ModelNotFoundException $exception) {
            return errorResponse(__('exceptions.404', ['model' => __('models.user')]), exception: $exception);
        } catch (Exception $exception) {
            return errorResponse(__('exceptions.try_again'), exception: $exception);
        }
    }

}

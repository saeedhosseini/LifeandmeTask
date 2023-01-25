<?php

namespace App\Http\Controllers\Panel\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\V1\UserStoreRequest;
use App\Http\Requests\Panel\V1\UserUpdateRequest;
use App\Http\Resources\Panel\V1\UserResource;
use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->list();
    }

    public function store(UserStoreRequest $request) : JsonResponse
    {
        $data = $request->validationData();
        return $this->service->add($data);
    }

    public function single($id): JsonResponse|UserResource
    {
        return $this->service->find($id);
    }

    public function update($id, UserUpdateRequest $request) : JsonResponse
    {
        $data = $request->validationData();
        return $this->service->edit($id, $data);
    }

    public function remove($id) : JsonResponse
    {
        return $this->service->delete($id);
    }

}

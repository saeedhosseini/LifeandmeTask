<?php

namespace App\Http\Controllers\Panel\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\V1\AdminLoginRequest;
use App\Http\Resources\Panel\V1\AdminResource;
use App\Http\Resources\Panel\V1\UserResource;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(AdminLoginRequest $request): JsonResponse|UserResource
    {
        $adminOrError = $this->service->findWithEmail($request->email);
        if ($adminOrError instanceof JsonResponse)
            return $adminOrError;
        else{
            $correctValidation = $this->service->checkPassword($adminOrError , $request->password);
            if (!$correctValidation)
                return errorResponse(__('auth.failed'));
            else{
                $generatedToken = $this->service->addNewToken($adminOrError);
                return successResponse([
                    'profile' => new AdminResource($adminOrError),
                    'token' => $generatedToken,
                ]);
            }
        }
    }

}

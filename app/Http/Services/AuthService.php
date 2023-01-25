<?php

namespace App\Http\Services;

use App\Models\Admin\Admin;
use App\Repositories\AdminRepositories;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthService
{

    private AdminRepositories $repositories;

    public function __construct(AdminRepositories $repositories)
    {
        $this->repositories = $repositories;
    }

    public function findWithEmail(string $email)
    {
        try {
            $admin = $this->repositories->findWithEmail($email);
            if ($admin){
                return $admin;
            }else{
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException $exception) {
            return errorResponse(__('exceptions.404', ['model' => __('models.user')]), exception: $exception);
        } catch (Exception $exception) {
            return errorResponse(__('exceptions.try_again'), exception: $exception);
        }
    }

    public function checkPassword(Admin $admin , string $password): bool
    {
       return Hash::check($password , $admin->password);
    }

    public function addNewToken(Admin $admin): string|\Laravel\Sanctum\string
    {
         $token = $admin->createToken('string');
        return $token->plainTextToken;
    }

}

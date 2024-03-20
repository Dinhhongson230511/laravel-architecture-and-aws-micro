<?php

namespace App\Services\Api;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends BaseService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function getUser(User $user)
    {
        $user->load('role.permissions');
        if($user) {
           return $this->responseData(true, new UserResource($user));
        }
        return $this->responseData(false);
    }

    public function getAll(int $page)
    {
        $users = $this->userRepository->paginate($page);
        return $this->responseData(true, new UserCollection($users));
    }

    public function store(array $params)
    {
        $user = $this->userRepository->create($params);
        if($user) {
            return $this->responseData(true, new UserResource($user));
        }
         return $this->responseData(false);
    }

    public function update(array $params, User $user)
    {
        $user = $this->userRepository->update($user->id, $params);
        if($user) {
            return $this->responseData(true, new UserResource($user));
        }
         return $this->responseData(false);
    }

    public function destroy(User $user)
    {
        $data = $this->userRepository->delete($user->id);
        if($data) {
            return $this->responseData(true, new UserResource($user));
        }
        return $this->responseData(false);
    }
}

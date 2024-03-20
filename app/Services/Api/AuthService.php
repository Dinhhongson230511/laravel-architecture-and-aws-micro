<?php

namespace App\Services\Api;

use App\Http\Resources\User\UserResource;
use App\Services\BaseService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService extends BaseService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken($request->email)->accessToken;
            $data['token'] = $token;
            $data['cookie'] = \cookie('jwt', $token, 3600);

            return $this->responseData(true, $data);
        }
        return $this->responseData(false);
    }

    public function logout()
    {
        $data['cookie'] = Cookie::forget('jwt');
        return $this->responseData(true, $data);
    }

    public function register(array $params)
    {
        $user = $this->userRepository->create($params);
        if($user) {
            return $this->responseData(true, new UserResource($user));
        }
        return $this->responseData(false);
    }

    public function getUser()
    {
        $user = Auth::user();
        $user->load('role.permissions');
        if($user) {
           return $this->responseData(true, new UserResource($user));
        }
        return $this->responseData(false);
    }

    public function userUpdateInfo(array $params)
    {
        $user = Auth::user();
        $user = $this->userRepository->update($user->id, $params);
        if($user) {
            return $this->responseData(true, new UserResource($user));
        }
        return $this->responseData(false);
    }

    public function changePassword(array $params)
    {
        $user = Auth::user();
        $user = $this->userRepository->update($user->id, $params);
        if($user) {
            return $this->responseData(true, new UserResource($user));
        }
        return $this->responseData(false);
    }
}

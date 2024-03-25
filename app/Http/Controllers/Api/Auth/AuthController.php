<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\DefaultController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\UserUpdateRequest;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Services\Api\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends DefaultController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->login($request);
        if ($response['status']) {
            $token = $response['data']['token'];
            $cookie = \cookie('jwt', $token, 3600);
            return \response([
                'token' => $token
            ])->withCookie($cookie);
        }
        return $this->responseUnAuthorized();
    }

    public function logout()
    {
        // $response = $this->authService->logout();
        $cookie = Cookie::forget('jwt');

        return \response([
            'mesdage' => 'success'
        ])->withCookie($cookie);
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register($request->all());
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function getUser()
    {
        $response = $this->authService->getUser();
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function userUpdateInfo(UserUpdateRequest $request)
    {
        $response = $this->authService->userUpdateInfo($request->all());
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $param['password'] = Hash::make($request->password);
        $response = $this->authService->changePassword($param);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('auth.message.change_password.success')
            );
        }
        return $this->responseBadRequest();
    }
}

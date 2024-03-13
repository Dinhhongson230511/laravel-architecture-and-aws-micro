<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\DefaultController;
use App\Services\Api\UserService;

class UserController extends DefaultController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show() {
        $response = $this->userService->getUserInfoById(1);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function getUser() {
        $response = $this->userService->getAll();
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }
}

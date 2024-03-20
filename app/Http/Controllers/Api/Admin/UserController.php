<?php


namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\DefaultController;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Api\Admin\User\UserCreateRequest;
use App\Http\Requests\Api\Admin\User\UserUpdateRequest;
use Illuminate\Support\Facades\Gate;

class UserController extends DefaultController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        Gate::authorize('view', 'users');

        $response = $this->userService->getAll(10);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function show(User $user)
    {
        Gate::authorize('view', 'users');
        $response = $this->userService->getUser($user);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function store(UserCreateRequest $request)
    {
        Gate::authorize('edit', 'users');
        $response = $this->userService->store($request->all());
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        Gate::authorize('edit', 'users');
        $response = $this->userService->update($request->all(), $user);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function destroy(User $user)
    {
        $response = $this->userService->destroy($user);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }
}

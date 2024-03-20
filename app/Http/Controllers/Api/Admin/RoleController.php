<?php


namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\DefaultController;
use App\Services\Api\RoleService;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Requests\Api\Admin\Role\RoleCreateRequest;
use App\Http\Requests\Api\Admin\Role\RoleUpdateRequest;

class RoleController extends DefaultController
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $response = $this->roleService->getAll(10);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function show(Role $role)
    {
        return $this->responseSuccess(
            $role,
            __('common.success_message')
        );
    }

    public function store(RoleCreateRequest $request)
    {
        $response = $this->roleService->store($request->all());
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $response = $this->roleService->update($request->all(), $role);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function destroy(Role $role)
    {
        $response = $this->roleService->destroy($role);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\DefaultController;
use App\Services\Api\PermissionService;

class PermissionController extends DefaultController
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index() {
        $response = $this->permissionService->getAll(10);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }
}

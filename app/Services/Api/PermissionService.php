<?php

namespace App\Services\Api;

use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Permission\PermissionResource;
use App\Models\Permission;
use App\Services\BaseService;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService extends BaseService
{
    protected PermissionRepositoryInterface $permissionRepository;

    public function __construct(
        PermissionRepositoryInterface $permissionRepository,
    ) {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAll()
    {
        $permissions = $this->permissionRepository->get();
        return $this->responseData(true, new PermissionCollection($permissions));
    }
}

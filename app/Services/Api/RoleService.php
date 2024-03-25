<?php

namespace App\Services\Api;

use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use App\Services\BaseService;
use App\Repositories\Interfaces\RoleRepositoryInterface;

/**
 * Class RoleService
 * @package App\Services
 */
class RoleService extends BaseService
{
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
    ) {
        $this->roleRepository = $roleRepository;
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        if($role) {
           return $this->responseData(true, new RoleResource($role));
        }
        return $this->responseData(false);
    }

    public function getAll(int $page)
    {
        $roles = $this->roleRepository->paginate($page, ['permissions']);
        return $this->responseData(true, new RoleCollection($roles));
    }

    public function store(array $params)
    {
        $role = $this->roleRepository->create($params);
        if($role) {
            if($params['permissions']) {
                $role->permissions()->sync($params['permissions']);
            }
            return $this->responseData(true, new RoleResource($role));
        }
         return $this->responseData(false);
    }

    public function update(array $params, Role $role)
    {
        $role = $this->roleRepository->update($role->id, $params);
        if($role) {
            if($params['permissions']) {
                $role->permissions()->sync($params['permissions']);
            }
            return $this->responseData(true, new RoleResource($role));
        }
         return $this->responseData(false);

    }

    public function destroy(Role $role)
    {
        $data = $this->roleRepository->delete($role->id);
        if($data) {
            return $this->responseData(true, new RoleResource($role));
        }
        return $this->responseData(false);
    }
}

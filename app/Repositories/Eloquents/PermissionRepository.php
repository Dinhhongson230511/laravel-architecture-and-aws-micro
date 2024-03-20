<?php


namespace App\Repositories\Eloquents;

use App\Repositories\Eloquents\BaseRepository;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }
}

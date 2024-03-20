<?php


namespace App\Repositories\Eloquents;

use App\Repositories\Eloquents\BaseRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }
}

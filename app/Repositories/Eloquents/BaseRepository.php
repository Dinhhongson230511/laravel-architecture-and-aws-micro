<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function paginate(int $page, array $relations = [])
    {
        return $this->model->with($relations)->paginate($page);
    }

    public function find(int $id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        return $model->delete();
    }

    public function findByColumn(string $column, $value, array $relations = [])
    {
        return $this->model->with($relations)->where($column, $value)->first();
    }
}

<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function get(array $relations = []);

    public function paginate(int $page, array $relations = []);

    public function find(int $id, array $relations = []);

    public function findByColumn(string $column, $value, array $relations = []);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}

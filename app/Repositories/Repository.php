<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\{Model, Collection};

abstract class Repository
{
    /**
     * Object of particular eloquent model.
     *
     * @var object
     */
    protected $model;

    /**
     * To get results with where condition using operator.
     *
     * @param string $key
     * @param string $operator
     * @param mixed $check
     * @return Collection
     */
    public function whereUsingOperator(string $key, string $operator, $check): Collection
    {
        return $this->model->where($key, $operator, $check)->get();
    }

    /**
     * Get All records for the model.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * To update particular model by checking specific keys.
     *
     * @param array $where
     * @param array $attributes
     * @return int
     */
    public function update(array $where, array $attributes): int
    {
        return $this->model->where($where)->update($attributes);
    }

    /**
     * To get where by first.
     *
     * @param array $where
     * @return Model|null
     */
    public function whereByFirst(array $where): ?Model
    {
        return $this->model->where($where)->first();
    }
}

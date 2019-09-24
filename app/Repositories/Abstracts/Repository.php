<?php

declare(strict_types = 1);

namespace App\Repositories\Abstracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

/**
 * Class Repository
 * @package App\Repositories\Abstracts
 */
abstract class Repository
{
    const DEFAULT_PER_PAGE = 15;
    const DEFAULT_ATTRIBUTES_FIELD = 'id';

    /**
     * @return string
     */
    abstract public function model(): string;

    /**
     * @return Model
     */
    final public function makeModel(): Model
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new RuntimeException('Class ' . $this->model() . 'must be instance of Illuminate\\Database\\Eloquent\\Model');
        }

        return $model;
    }

    /**
     * @return Builder
     */
    final public function makeQuery(): Builder
    {
        return $this->makeModel()->newQuery();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->makeQuery()->create($data);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(
        int $perPage = self::DEFAULT_PER_PAGE,
        array $columns = ['*']
    ): LengthAwarePaginator {
        return $this->makeQuery()->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @param $attributeValue
     * @param string $attributeField
     * @return int
     */
    public function update(
        array $data,
        $attributeValue,
        string $attributeField = self::DEFAULT_ATTRIBUTES_FIELD
    ): int {
        return $this->makeQuery()->where($attributeField, $attributeValue)->update($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->makeQuery()->where('id', $id)->delete();
    }

    /**
     * @param $id
     * @param array $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->makeQuery()->find($id, $columns);
    }
}
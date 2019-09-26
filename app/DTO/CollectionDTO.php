<?php

declare(strict_types = 1);

namespace App\DTO;

use Illuminate\Support\Collection;

/**
 * Class CollectionDTO
 * @package App\DTO
 */
class CollectionDTO extends BaseDTO
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * CollectionDTO constructor.
     */
    public function __construct()
    {
        $this->collection = collect();
    }

    /**
     * @return array
     */
    protected function jsonData(): array
    {
        return $this->collection->toArray();
    }

    /**
     * @param BaseDTO $item
     */
    public function pushItem(BaseDTO $item): void
    {
        $this->collection->push($item);
    }

    /**
     * @param string $key
     * @param BaseDTO $item
     */
    public function putItem(string $key, BaseDTO $item): void
    {
        $this->collection->put($key, $item);
    }
}
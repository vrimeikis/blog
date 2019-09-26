<?php

declare(strict_types = 1);

namespace App\DTO;

use JsonSerializable;

/**
 * Class BaseDTO
 * @package App\DTO
 */
abstract class BaseDTO implements JsonSerializable
{

    /**
     * @return array
     */
    final public function jsonSerialize(): array
    {
        return $this->jsonData();
    }

    /**
     * @return array
     */
    abstract protected function jsonData(): array;

}
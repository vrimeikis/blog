<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class EmptyDataException
 * @package App\Exceptions
 */
class EmptyDataException extends Exception
{
    /**
     * @return EmptyDataException
     */
    public static function noData(): EmptyDataException
    {
        return new self('No data', JsonResponse::HTTP_NOT_FOUND);
    }
}

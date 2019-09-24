<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\ContactMessage;
use App\Repositories\Abstracts\Repository;

/**
 * Class ContactMessageRepository
 * @package App\Repositories
 */
class ContactMessageRepository extends Repository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return ContactMessage::class;
    }
}
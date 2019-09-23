<?php

declare(strict_types = 1);

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\ContactMessage
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 * @property string $email
 * @property string $message
 * @method static Builder|ContactMessage newModelQuery()
 * @method static Builder|ContactMessage newQuery()
 * @method static Builder|ContactMessage query()
 * @method static Builder|ContactMessage whereCreatedAt($value)
 * @method static Builder|ContactMessage whereEmail($value)
 * @method static Builder|ContactMessage whereId($value)
 * @method static Builder|ContactMessage whereMessage($value)
 * @method static Builder|ContactMessage whereName($value)
 * @method static Builder|ContactMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactMessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}

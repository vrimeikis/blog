<?php

declare(strict_types = 1);

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Article
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $title
 * @property string|null $cover
 * @property string $content
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article query()
 * @method static Builder|Article whereContent($value)
 * @method static Builder|Article whereCover($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereTitle($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 */
class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}

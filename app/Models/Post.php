<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Support\IdeHelper\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Post
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $category_id
 * @property-read \App\Models\Category|null $category
 * @property-read string $formatted_content
 * @property-read bool $published
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post published()
 * @method static Builder|Post query()
 * @method static Builder|Post whereCategoryId($value)
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post wherePublishedAt($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;
    // use BelongsToTenant; // tenant_id attribute/column
    use InteractsWithMedia;
    use HasDatabase;
    use HasUuids;
    use TenantContext;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function (Post $post) {
            $post->slug = Str::slug($post->title);
        });

        static::updating(function (Post $post) {
            if (! $post->published_at) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function getPublishedAttribute(): bool
    {
        return (bool) $this->published_at?->isPast();
    }

    public function getFormattedContentAttribute(): string
    {
        return Str::markdown($this->content);
    }

    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at')->whereDate('published_at', '<=', now());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

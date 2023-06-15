<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

/**
 * App\Models\DynamicContent
 *
 * @property string $id
 * @property string|null $organization_id
 * @property string $slug
 * @property string $title
 * @property string|null $cover_image
 * @property string|null $small_description
 * @property string|null $content
 * @property bool $active
 * @property string|null $css_code
 * @property string|null $js_code
 * @property string|null $html_code
 * @property \Illuminate\Support\Carbon|null $show_from
 * @property \Illuminate\Support\Carbon|null $show_to
 * @property AsCollection|null $search_tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Database\Factories\DynamicContentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereCssCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereHtmlCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereJsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereSearchTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereShowFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereShowTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereSmallDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DynamicContent whereUpdatedAt($value)
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @mixin \Eloquent
 */
class DynamicContent extends Model implements HasMedia
{
    use HasFactory;
    // use HasUuid; // Cria uma coluna chmada uuid
    use HasUuids;
    use InteractsWithMedia;

    protected $fillable = [
        'organization_id',
        'slug',
        'title',
        'cover_image',
        'small_description',
        'content',
        'active',
        'css_code',
        'js_code',
        'html_code',
        'show_from',
        'show_to',
        'search_tags',
    ];

    protected $casts = [
        'active' => 'boolean',
        'show_from' => 'datetime',
        'show_to' => 'datetime',
        'search_tags' => AsCollection::class,
    ];
}

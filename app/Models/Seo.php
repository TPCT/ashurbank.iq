<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasUploads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Seo
 *
 * @property int $id
 * @property int $user_id
 * @property string $model_type
 * @property int $model_id
 * @property array|null $title
 * @property array|null $description
 * @property array|null $image
 * @property \App\Models\User $author
 * @property string|null $robots
 * @property array|null $keywords
 * @property array|null $canonical_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|Seo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereCanonicalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereRobots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereUserId($value)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class Seo extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    protected $table = "seo";
    use HasFactory, HasTranslations, Auditable, HasAuthor;

    public const FOLLOW = "follow";
    public const INDEX = "index";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'image' => 'array',
        'author' => 'array',
        'keywords' => 'array',
        'canonical_url' => 'array',
        'robots' => 'array'
    ];

    public array $translatable = [
        'title', 'description', 'image', 'author', 'keywords', 'canonical_url'
    ];

    public static function getRobots(): array
    {
        return [
            self::INDEX => __(self::INDEX),
            self::FOLLOW => __(self::FOLLOW)
        ];
    }
}

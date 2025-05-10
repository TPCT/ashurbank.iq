<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\interfaces\HasVersionControl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property int $user_id
 * @property int $dropdown_id
 * @property string|null $image
 * @property string|null $icon
 * @property array $title
 * @property array $second_title
 * @property array $description
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|Slider active()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereDropdownId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUserId($value)
 * @property string $slides
 * @property string $slug
 * @property-read \App\Models\Dropdown $dropdown
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSlides($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSlug($value)
 * @property array|null $bullets
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereBullets($value)
 * @property string $category
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCategory($value)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @mixin \Eloquent
 */

class Slider extends Model implements \OwenIt\Auditing\Contracts\Auditable, HasVersionControl
{
    public const HOMEPAGE_SLIDER = "Homepage Slider";


    use HasFactory, HasAuthor, Auditable, HasStatus, HasTranslations, \App\Helpers\HasVersionControl;

    public static function getCategories(){
        return [
            self::HOMEPAGE_SLIDER => __(self::HOMEPAGE_SLIDER),
        ];
    }

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'title' => 'array',
        'second_title' => 'array',
        'description' => 'array',
        'bullets' => 'array',
        'slides' => 'array',
    ];

    public array $translatable = [
        'title', 'second_title', 'description'
    ];

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

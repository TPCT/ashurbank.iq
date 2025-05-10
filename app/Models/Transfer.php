<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Transfer
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $image
 * @property string|null $inner_image
 * @property array $title
 * @property array|null $second_title
 * @property array|null $description
 * @property array|null $features
 * @property string|null $button_url
 * @property string $view
 * @property string $slug
 * @property int $status
 * @property int $weight
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read array $section_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $sections
 * @property-read int|null $sections_count
 * @property-read \App\Models\Seo $seo
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer active()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer section($section)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereButtonUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereInnerImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereWeight($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class Transfer extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, HasVersionControl
{
    public const BANK_TRANSFER_VIEW = "Bank Transfer View";
    public const MONEY_GRAM_VIEW = "Money Gram View";

    public static function getViews(){
        return [
            self::BANK_TRANSFER_VIEW => __(self::BANK_TRANSFER_VIEW),
            self::MONEY_GRAM_VIEW => __(self::MONEY_GRAM_VIEW),
        ];
    }

    use HasFactory, HasTranslations, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, \App\Helpers\HasSeo, HasSlug, \App\Helpers\HasSection, \App\Helpers\HasVersionControl;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'second_title' => 'array',
        'description' => 'array',
        'features' => 'array',
    ];

    public array $translatable = [
        'title', 'second_title', 'description'
    ];

    public function getVersionControlUrl()    {
        return route('transfers.show', ['transfer' => $this->slug, 'section' => $this->sections->first()]);
    }
}

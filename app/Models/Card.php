<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasSearch;
use App\Helpers\HasSection;
use App\Helpers\HasSeo;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Card
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $image
 * @property string|null $inner_image
 * @property array $title
 * @property array|null $description
 * @property array|null $content
 * @property string $slug
 * @property int $status
 * @property int $weight
 * @property int $promote
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $features
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read array $section_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $sections
 * @property-read int|null $sections_count
 * @property-read \App\Models\Seo $seo
 * @property-read mixed $translations
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Card active()
 * @method static \Illuminate\Database\Eloquent\Builder|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|Card section($section)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereInnerImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Card wherePromote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereWeight($value)
 * @property string|null $form_type
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereFormType($value)
 * @mixin \Eloquent
 */
class Card extends WeightedModel implements Auditable, Searchable, HasVersionControl
{
    use HasFactory, HasTranslations, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, HasSeo, HasSlug, HasSection, HasSearch, \App\Helpers\HasVersionControl;

    public const SINGLE_FORM = "Single Form";
    public const PROGRESS_FORM = "Progress Form";



    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'second_title' => 'array',
        'description' => 'array',
        'content' => 'array',
        'features' => 'array'
    ];

    public static function getFormTypes(){
        return  [
            self::SINGLE_FORM => __(self::SINGLE_FORM),
            self::PROGRESS_FORM => __(self::PROGRESS_FORM)
        ];
    }

    public array $translatable = [
        'title', 'second_title', 'description', 'content'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('cards.show', ['section' => $this->sections->first(), 'card' => $this->slug]);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }


    public function getVersionControlUrl()    {
        return route('cards.show', ['section' => $this->sections->first(), 'card' => $this->slug]);
    }
}

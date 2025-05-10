<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasSearch;
use App\Helpers\HasSection;
use App\Helpers\HasSeo;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Account
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $image
 * @property string|null $inner_image
 * @property array $title
 * @property array|null $second_title
 * @property array|null $description
 * @property array|null $content
 * @property array|null $features
 * @property string $slug
 * @property int $status
 * @property int $weight
 * @property int $promote
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
 * @property-read mixed $translations
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Account active()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account section($section)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereInnerImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePromote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereWeight($value)
 * @property string|null $conditions
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereConditions($value)
 * @mixin \Eloquent
 */
class Account extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable, \App\Helpers\interfaces\HasVersionControl
{
    use HasFactory, HasTranslations, HasAuthor, HasStatus, Auditable, HasSeo, HasSlug, HasSection, HasSearch, HasVersionControl;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'second_title' => 'array',
        'description' => 'array',
        'content' => 'array',
        'features' => 'array',
        'conditions' => 'array'
    ];

    public array $translatable = [
        'title', 'second_title', 'description', 'content'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('accounts.show', ['section' => $this->sections->first(), 'account' => $this->slug]);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    public function version_control(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(VersionControl::class, 'model');
    }

    public function getVersionControlUrl()    {
        return route('accounts.show', ['section' => $this->sections->first(), 'account' => $this->slug]);
    }
}

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
use OwenIt\Auditing\Auditable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Loan
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $image
 * @property string|null $inner_image
 * @property array $title
 * @property array|null $second_title
 * @property array|null $description
 * @property array|null $content
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
 * @method static \Illuminate\Database\Eloquent\Builder|Loan active()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan section($section)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereInnerImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan wherePromote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereWeight($value)
 * @property float|null $interest_rate
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereInterestRate($value)
 * @mixin \Eloquent
 */
class Loan extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable, HasVersionControl
{
    use HasFactory, HasTranslations, HasAuthor, HasStatus, Auditable, HasSeo, HasSlug, HasSection, HasSearch, \App\Helpers\HasVersionControl;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'second_title' => 'array',
        'description' => 'array',
        'content' => 'array'
    ];

    public array $translatable = [
        'title', 'second_title', 'description', 'content'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('loans.show', ['section' => $this->sections->first(), 'loan' => $this->slug]);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    public function getVersionControlUrl()    {
        return route('loans.show', ['section' => $this->sections->first(), 'loan' => $this->slug]);
    }
}

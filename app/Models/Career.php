<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasSearch;
use App\Helpers\HasSeo;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Career
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property array $description
 * @property string $qualifications
 * @property string $skills
 * @property string $slug
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Seo $seo
 * @method static \Illuminate\Database\Eloquent\Builder|Career active()
 * @method static \Illuminate\Database\Eloquent\Builder|Career newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Career newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Career query()
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Career wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereQualifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereUserId($value)
 * @property-read \App\Models\User $user
 * @property int $weight
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereWeight($value)
 * @property array $benefits
 * @property array $desirable
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereDesirable($value)
 * @property string $location
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereLocation($value)
 * @property int $category_id
 * @property-read \App\Models\Dropdown $category
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereCategoryId($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class Career extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable, \App\Helpers\interfaces\HasVersionControl
{
    use HasFactory, HasAuthor, HasStatus, Auditable, HasSeo, HasTranslations, HasSlug, HasSearch, HasVersionControl;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatable = [
        'title', 'location', 'description', 'qualifications', 'desirable', 'benefits'
    ];

    protected $casts = [
        'title' => 'array',
        'location' => 'array',
        'description' => 'array',
        'qualifications' => 'array',
        'desirable' => 'array',
        'benefits' => 'array',
    ];

    public function category(){
        return $this->belongsTo(Dropdown::class, 'category_id', 'id')->whereCategory(Dropdown::CAREERS_CATEGORY);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('careers.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    public function getVersionControlUrl()    {
        return route('careers.show', ['career' => $this->slug]);
    }
}

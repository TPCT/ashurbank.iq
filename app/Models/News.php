<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Models\Media\Media;
use App\Helpers\HasLingual;
use App\Helpers\HasSearch;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\HasUploads;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\News
 *
 * @property int $id
 * @property string|null $image
 * @property array $title
 * @property array|null $description
 * @property array|null $content
 * @property array|null $header_image
 * @property array|null $header_title
 * @property array|null $header_description
 * @property int $user_id
 * @property string $slug
 * @property string $published_at
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Seo $seo
 * @method static \Illuminate\Database\Eloquent\Builder|News active()
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeaderDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeaderImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeaderTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUserId($value)
 * @property string $slider
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlider($value)
 * @property-read \App\Models\User $user
 * @property int $category_id
 * @property int $heading_news
 * @property-read \App\Models\Dropdown $category
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeadingNews($value)
 * @property-read mixed $translations
 * @property int $weight
 * @method static \Illuminate\Database\Eloquent\Builder|News whereWeight($value)
 * @property-read mixed $language_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $languages
 * @property-read int|null $languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|News language($locale)
 * @mixin \Eloquent
 */
class News extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable, HasVersionControl
{
    use HasFactory, HasTranslations, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, \App\Helpers\HasSeo, HasSlug, HasLingual, HasTimestamps, HasSearch, \App\Helpers\HasVersionControl;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'header_image' => 'array',
        'header_title' => 'array',
        'header_description' => 'array',
        'description' => 'array',
        'content' => 'array',
        'slider' => 'array'
    ];

    public array $translatable = [
        'title', 'header_image',
        'header_title', 'header_description', 'description',
        'content'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('news.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    public function category(){
        return $this->belongsTo(Dropdown::class, 'category_id', 'id')
            ->active()
            ->whereCategory(Dropdown::NEWS_CATEGORY);
    }

    public function getVersionControlUrl()    {
        return route('news.show', ['news' => $this->slug]);
    }

    public function getImagePathAttribute()
    {
        if (is_numeric($this->attributes['image'])) {
            $media = \Awcodes\Curator\Models\Media::find($this->attributes['image']);
            return $media ? $media->path : null;
        }
        return $this->attributes['image'];
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->getOriginal('image') && !is_numeric($model->image)) {
                $model->image = $model->getOriginal('image');
            }
        });
    }
}

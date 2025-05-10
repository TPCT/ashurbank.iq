<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\interfaces\HasVersionControl;
use App\Settings\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @property array $title
 * @property array|null $keywords
 * @property array|null $header_image
 * @property array|null $header_title
 * @property array|null $header_description
 * @property array|null $description
 * @property array|null $content
 * @property array|null $footer_content
 * @property int $user_id
 * @property string $slug
 * @property string $view
 * @property string $published_at
 * @property int $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Seo $seo
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereFooterContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereHeaderDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereHeaderImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereHeaderTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page active()
 * @property-read \App\Models\User $user
 * @property string|null $prefix
 * @property-read array $section_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $sections
 * @property-read int|null $sections_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page section($section)
 * @property int $direct_access
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDirectAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page directAccess()
 * @property-read mixed $link
 * @mixin \Eloquent
 */
class Page extends Model implements Auditable, Searchable, HasVersionControl
{
    use HasFactory, HasTranslations, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, \App\Helpers\HasSeo, HasSlug, \App\Helpers\HasSection, \App\Helpers\HasVersionControl;

    public const DEFAULT_VIEW = "Default View";
    public const TRANSFERS_VIEW = "Transfers View";
    public const SERVICES_VIEW = "Services View";
    public const SIMPLE_VIEW = "Simple View";

    public static function getViews(){
        return [
            self::DEFAULT_VIEW => __(self::DEFAULT_VIEW),
            self::TRANSFERS_VIEW => __(self::TRANSFERS_VIEW),
            self::SERVICES_VIEW => __(self::SERVICES_VIEW),
            self::SIMPLE_VIEW  => __(self::SIMPLE_VIEW),
        ];
    }

    protected $appends = ['link'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'header_image' => 'array',
        'header_title' => 'array',
        'header_description' => 'array',
        'description' => 'array',
        'content' => 'array',
    ];

    public array $translatable = [
        'title', 'keywords', 'header_image',
        'header_title', 'header_description', 'description',
        'content'
    ];

    public function scopeDirectAccess(): Page|\Illuminate\Database\Eloquent\Builder
    {
        return $this->where('direct_access', true);
    }

    public function getLinkAttribute(){
        $link = "/" . app()->getLocale() . "/";
        if ($this->prefix)
            $link .= $this->prefix . "/";
        $link .= $this->slug;
        return $link;
    }

    public function getSearchResult(): SearchResult
    {
        $url = $this->link;

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    public static function results($keys){
        return self::directAccess()
            ->offset(app(Site::class)->search_page_size * request('page', 0))
            ->limit(app(Site::class)->search_page_size)
            ->where(function($query) use ($keys){
                foreach($keys as $key){
                    $query->orWhere($key, 'LIKE', '%'.request('search', '').'%');
                }
            })->get();
    }

    public function getSearchUrl(){
        $url = "/";
        if ($this->sections?->count())
            $url .= $this->sections->first()->slug . "/";
        if ($this->prefix)
            $url .= $this->prefix . "/";
        return $url . $this->slug;
    }

    public function getVersionControlUrl()    {
        return route('page.show', ['slug' => $this->slug, 'section' => $this->sections->first()]);
    }
}

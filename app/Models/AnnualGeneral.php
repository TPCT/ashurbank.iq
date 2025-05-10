<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\AnnualGeneral
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property array $link
 * @property int $status
 * @property int $weight
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral active()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualGeneral whereWeight($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class AnnualGeneral extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable, HasVersionControl
{
    use HasFactory, HasStatus, HasAuthor, Auditable, HasTranslations, \App\Helpers\HasVersionControl;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'title' => 'array',
        'link' => 'array'
    ];

    public array $upload_attributes = [
        'link'
    ];

    public array $translatable = [
        'title',
        'link'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('investor-relations.annual-generals');

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

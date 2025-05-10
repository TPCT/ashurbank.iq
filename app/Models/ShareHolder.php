<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\ShareHolder
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $image
 * @property array $name
 * @property array $title
 * @property int $shares
 * @property int $status
 * @property int $weight
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder active()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereShares($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareHolder whereWeight($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class ShareHolder extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable
{
    use HasFactory, HasStatus, HasAuthor, Auditable, HasTranslations;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'title' => 'array',
        'link' => 'array',
        'name' => 'array'
    ];

    public array $upload_attributes = [
        'image'
    ];

    public array $translatable = [
        'title',
        'image',
        'name'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('investor-relations.shareholders');

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}

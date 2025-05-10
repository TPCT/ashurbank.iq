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
 * App\Models\FinancialStatement
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
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement active()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereWeight($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class FinancialStatement extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable, HasVersionControl
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
        $url = route('investor-relations.financial-statements');

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

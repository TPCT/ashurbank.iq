<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\interfaces\HasVersionControl;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\District
 *
 * @property int $id
 * @property int $user_id
 * @property int $city_id
 * @property array $title
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\City $city
 * @method static \Illuminate\Database\Eloquent\Builder|District active()
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|District wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUserId($value)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class District extends Model implements \OwenIt\Auditing\Contracts\Auditable, HasVersionControl
{
    use HasFactory, HasTranslations, HasAuthor, HasStatus, Auditable, \App\Helpers\HasVersionControl;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'title' => 'array'
    ];

    public array $translatable = [
        'title'
    ];

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

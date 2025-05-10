<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Branch
 *
 * @property int $id
 * @property int $user_id
 * @property array $name
 * @property array|null $address
 * @property array|null $p_o_box
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $email
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|Branch active()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch wherePOBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUserId($value)
 * @property-read \App\Models\User $user
 * @property int $weight
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereWeight($value)
 * @property string|null $longitude
 * @property string|null $latitude
 * @property int $city_id
 * @property int $is_atm
 * @property-read \App\Models\City $city
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereIsAtm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereLongitude($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class Branch extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, HasVersionControl
{
    use HasFactory, HasStatus, Auditable, HasAuthor, HasTranslations, \App\Helpers\HasVersionControl;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'name' => 'array',
        'address' => 'array'
    ];

    public array $translatable = [
        'name', 'address'
    ];

    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

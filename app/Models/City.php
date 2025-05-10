<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\interfaces\HasVersionControl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\City
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|City active()
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUserId($value)
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branches
 * @property-read int|null $branches_count
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class City extends Model implements Auditable, HasVersionControl
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasTranslations, HasAuthor, HasStatus, \App\Helpers\HasVersionControl;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'title' => 'array'
    ];

    public array $translatable = [
        'title'
    ];

    public function branches(){
        return $this->hasMany(Branch::class, 'city_id', 'id');
    }

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

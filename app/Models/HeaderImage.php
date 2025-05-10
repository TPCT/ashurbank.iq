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
 * App\Models\HeaderImage
 *
 * @property int $id
 * @property int $user_id
 * @property string $path
 * @property array $image
 * @property array $title
 * @property array $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage active()
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class HeaderImage extends Model implements Auditable, HasVersionControl
{
    use HasFactory, HasAuthor, HasTranslations, \OwenIt\Auditing\Auditable, \App\Helpers\HasVersionControl;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public array $translatable = [
        'title', 'description', 'image'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'image' => 'array'
    ];

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

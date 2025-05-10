<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\SeoLink
 *
 * @property int $id
 * @property int $user_id
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Seo $seo
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoLink whereUserId($value)
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class SeoLink extends Model implements Auditable
{
    use HasFactory, HasAuthor, \App\Helpers\HasSeo, \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];
}

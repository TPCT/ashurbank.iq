<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Faq
 *
 * @property int $id
 * @property array $title
 * @property array|null $description
 * @property int $promote_to_homepage
 * @property int $user_id
 * @property string $published_at
 * @property int $status
 * @property int $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Faq active()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq query()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq wherePromoteToHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereWeight($value)
 * @property string|null $image
 * @property int $is_video
 * @property array|null $video_url
 * @property mixed $0
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereIsVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereVideoUrl($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class Faq extends WeightedModel implements Auditable, HasVersionControl
{
    use HasFactory, HasStatus, HasAuthor, \OwenIt\Auditing\Auditable, HasTranslations, \App\Helpers\HasVersionControl;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'video_url'
    ];

    public array $translatable = [
        'title',
        'description',
        'video_url'
    ];

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

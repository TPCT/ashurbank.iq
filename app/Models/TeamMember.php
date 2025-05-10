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
 * App\Models\TeamMember
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int $position_id
 * @property string|null $image
 * @property array $name
 * @property array|null $description
 * @property string $published_at
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Dropdown|null $category
 * @property-read \App\Models\Dropdown|null $position
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember active()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereUserId($value)
 * @property-read \App\Models\User $user
 * @property int $weight
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereWeight($value)
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class TeamMember extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, HasVersionControl
{
    use HasFactory, HasStatus, HasAuthor, Auditable, HasTranslations, \App\Helpers\HasVersionControl;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'position' => 'array'
    ];

    public array $upload_attributes = [
        'image'
    ];

    public array $translatable = [
        'name', 'description', 'position'
    ];

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

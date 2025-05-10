<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string $slug
 * @property int $status
 * @property int $weight
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Currency active()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereWeight($value)
 * @property float $rate
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereRate($value)
 * @mixin \Eloquent
 */
class Currency extends WeightedModel implements Auditable, HasVersionControl
{
    use HasFactory, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, HasSlug, \App\Helpers\HasVersionControl;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

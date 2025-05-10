<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Models\TranslationCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Translation
 *
 * @property int $id
 * @property int $user_id
 * @property int $translation_category_id
 * @property string $lang
 * @property string $key
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\TranslationCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereTranslationCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLocales(string $column, array $locales)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @mixin \Eloquent
 */
class Translation extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasAuthor, HasTranslations, Auditable;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public array $translatable = [
        'content'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TranslationCategory::class);
    }
}

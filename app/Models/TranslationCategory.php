<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\TranslationCategory
 *
 * @property int $id
 * @property int $user_id
 * @property string $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Translation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory whereUserId($value)
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationCategory whereTitle($value)
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class TranslationCategory extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasAuthor;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translation::class);
    }

    public static function getTranslations($locale, $group): array{
        $group = static::query()->where('title', $group)->first();
        if (!$group)
            return [];
        return Translation::where('translation_category_id', $group->id)
                ->orderByDesc('updated_at')
                ->get()
                ->map(function(Translation $translation) use ($locale){
                    return [
                        'key' => $translation->key,
                        'text' => $translation->translate('content', $locale) ?: $translation->key
                    ];
                })
                ->pluck('text', 'key')
                ->toArray();
    }
}

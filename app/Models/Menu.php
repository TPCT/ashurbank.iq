<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\interfaces\HasVersionControl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property string $category
 * @property array $links
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUserId($value)
 * @property int $dropdown_id
 * @property string $published_at
 * @property int $status
 * @property-read \App\Models\Dropdown $dropdown
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDropdownId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereStatus($value)
 * @property string|null $view_all_link
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereViewAllLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu active()
 * @property-read \App\Models\User $user
 * @property array|null $buttons
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereButtons($value)
 * @mixin \Eloquent
 */

class Menu extends Model implements Auditable, HasVersionControl
{
    use HasFactory, HasAuthor, \OwenIt\Auditing\Auditable, HasStatus, \App\Helpers\HasVersionControl;

    public const HEADER_MENU = "Header Menu";
    public const FOOTER_MENU = "Footer Menu";
    public const SIDE_MENU = "Side Menu";
    public const SITE_MAP_MENU = "Site Map Menu";
    public const TOP_HEADER_MENU = "Top Header Menu";


    public static function getCategories(): array
    {
        return [
            self::TOP_HEADER_MENU => __(self::TOP_HEADER_MENU),
            self::HEADER_MENU => __(self::HEADER_MENU),
            self::FOOTER_MENU => __(self::FOOTER_MENU),
            self::SIDE_MENU => __(self::SIDE_MENU),
            self::SITE_MAP_MENU => __(self::SITE_MAP_MENU)
        ];
    }

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'links' => 'array',
        'buttons' => 'array'
    ];

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

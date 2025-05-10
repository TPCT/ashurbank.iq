<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\interfaces\HasVersionControl;
use App\Helpers\Utilities;
use App\Models\Block;
use App\Models\TeamMember;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Dropdown
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property string $brief
 * @property string $url
 * @property string $image
 * @property string $slug
 * @property string $published_at
 * @property string $category
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User|null $author
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereBrief($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUserId($value)
 * @property array|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown active()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slider> $sliders
 * @property-read int|null $sliders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TeamMember> $team_members
 * @property-read int|null $team_members_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Entity> $entities
 * @property-read int|null $entities_count
 * @property array $second_title
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereSecondTitle($value)
 * @property-read mixed $translations
 * @property array|null $validations
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereValidations($value)
 * @mixin \Eloquent
 */
class Dropdown extends Model implements \OwenIt\Auditing\Contracts\Auditable, HasVersionControl
{
    use HasFactory, HasAuthor, HasTranslations, Auditable, HasStatus, HasSlug, \App\Helpers\HasVersionControl;

    public const MENU_CATEGORY = "Menu Category";
    public const NEWS_CATEGORY = "News Category";
    public const FAQ_CATEGORY = "Faq Category";
    public const BLOCK_CATEGORY = "Block Category";
    public const CAREERS_CATEGORY = "Careers Category";
    public const DOWNLOADABLE_FILE = "Downloadable File Category";
    public const CONTACT_US_MESSAGE_TYPE = "Contact Us Message Type";
    public const TRANSFER_CATEGORY = "Transfer Category";
    public const MARTIAL_STATUS = "Martial Status";
    public const SCIENTIFIC_STATUS = "Scientific Status";
    public const ACCOMMODATION_TYPE = "Accommodation Type";
    public const LABOR_SECTOR_TYPE = "Labor Sector Type";
    public const LOAN_PAYMENT_METHOD = "Loan Payment Method";

    public const DOCUMENT_TYPE = "Document Type";

    public static function getCategories(): array
    {
        return [
            self::MENU_CATEGORY => __(self::MENU_CATEGORY),
            self::NEWS_CATEGORY => __(self::NEWS_CATEGORY),
            self::FAQ_CATEGORY => __(self::FAQ_CATEGORY),
            self::BLOCK_CATEGORY => __(self::BLOCK_CATEGORY),
            self::DOWNLOADABLE_FILE => __(self::DOWNLOADABLE_FILE),
            self::CONTACT_US_MESSAGE_TYPE => __(self::CONTACT_US_MESSAGE_TYPE),
            self::CAREERS_CATEGORY => __(self::CAREERS_CATEGORY),
            self::TRANSFER_CATEGORY => __(self::TRANSFER_CATEGORY),
            self::ACCOMMODATION_TYPE => __(self::ACCOMMODATION_TYPE),
            self::MARTIAL_STATUS => __(self::MARTIAL_STATUS),
            self::SCIENTIFIC_STATUS => __(self::SCIENTIFIC_STATUS),
            self::LABOR_SECTOR_TYPE => __(self::LABOR_SECTOR_TYPE),
            self::LOAN_PAYMENT_METHOD => __(self::LOAN_PAYMENT_METHOD),
            self::DOCUMENT_TYPE => __(self::DOCUMENT_TYPE)
        ];
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatable = [
        'title', 'description', 'image', 'second_title'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'image' => 'array',
        'second_title' => 'array',
        'validations' => 'array'
    ];

    public array $upload_attributes = [
        'image'
    ];

    public function blocks(){
        return $this
            ->hasMany(Block::class, 'dropdown_id', 'id')
            ->where('dropdown_id', $this->id);
    }

    public function getVersionControlUrl()    {
        // TODO: Implement getVersionControlUrl() method.
    }
}

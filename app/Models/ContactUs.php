<?php

namespace App\Models;

use App\Helpers\HasMailing;
use App\Helpers\HasUploads;
use App\Models\Dropdown;
use App\Settings\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\ContactUs
 *
 * @property int $id
 * @property int $dropdown_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereUpdatedAt($value)
 * @property string $subject
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereSubject($value)
 * @mixin \Eloquent
 */
class ContactUs extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable, HasMailing;

    public ?string $mailing_to = null;
    public ?string $mailing_subject = "Contact Us Application";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mailing_to = app(Site::class)->contact_us_mailing_list;
    }


    protected $guarded = ['id', 'created_at', 'updated_at'];
}

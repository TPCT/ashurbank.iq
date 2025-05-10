<?php

namespace App\Models;

use App\Helpers\HasMailing;
use App\Settings\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\CardWebform
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform query()
 * @property int $id
 * @property int $card_id
 * @property string|null $name_on_card
 * @property string|null $branch_id
 * @property string|null $date
 * @property string|null $account_number
 * @property string|null $full_name
 * @property string|null $date_of_birth
 * @property string|null $phone_number
 * @property string|null $full_name_en
 * @property string|null $full_name_ar
 * @property string|null $nationality
 * @property string|null $place_date_of_birth
 * @property string|null $address
 * @property string|null $preferred_communication_method
 * @property string|null $email
 * @property string|null $workplace
 * @property string|null $current_position
 * @property string|null $work_start_date
 * @property string|null $monthly_salary
 * @property string|null $extra_work
 * @property string|null $other_sources_of_income
 * @property string|null $card_identity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereCardIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereCurrentPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereExtraWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereFullNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereFullNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereMonthlySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereNameOnCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereOtherSourcesOfIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform wherePlaceDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform wherePreferredCommunicationMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereWorkStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CardWebform whereWorkplace($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\Card $card
 * @mixin \Eloquent
 */


class CardWebform extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

//    public function __construct(array $attributes = [])
//    {
//        parent::__construct($attributes);
//        $this->email = app(Site::class)->card_appliers_mailing_list;
//    }


    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function card(){
        return $this->belongsTo(Card::class);
    }
}

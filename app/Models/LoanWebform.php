<?php

namespace App\Models;

use App\Helpers\HasMailing;
use App\Settings\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\LoanWebform
 *
 * @property int $id
 * @property int $loan_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $nationality
 * @property string $place_date_of_birth
 * @property string $address
 * @property string $phone_number
 * @property string $preferred_method_of_communication
 * @property string $email
 * @property string $workplace
 * @property string $current_position
 * @property string $work_start_date
 * @property string $monthly_salary
 * @property string $extra_work
 * @property string $other_sources_of_income
 * @property string $loan_amount
 * @property string $payment_period
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Loan $loan
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereCurrentPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereExtraWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereLoanAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereMonthlySalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereOtherSourcesOfIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform wherePaymentPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform wherePlaceDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform wherePreferredMethodOfCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereWorkStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanWebform whereWorkplace($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @mixin \Eloquent
 */
class LoanWebform extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

//    public function __construct(array $attributes = [])
//    {
//        parent::__construct($attributes);
//        $this->email = app(Site::class)->finance_appliers_mailing_list;
//    }

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function loan(){
        return $this->belongsTo(Loan::class);
    }
}

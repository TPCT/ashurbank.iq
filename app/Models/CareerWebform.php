<?php

namespace App\Models;

use App\Helpers\HasMailing;
use App\Helpers\HasUploads;
use App\Models\Career;
use App\Settings\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\CareerWebform
 *
 * @property int $id
 * @property int $career_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $cv
 * @property string|null $cover_letter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Career $career
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform query()
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereCareerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereCoverLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereUpdatedAt($value)
 * @property string $date_of_birth
 * @property string $gender
 * @property string $phone_number
 * @property string $address
 * @property string $country
 * @property string $city
 * @property string $qualification
 * @property string $specialization
 * @property string $scientific_expertise
 * @property string $years_of_experience
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereQualification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereScientificExpertise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereYearsOfExperience($value)
 * @property string $qualifications
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform whereQualifications($value)
 * @property string $place_date_of_birth
 * @method static \Illuminate\Database\Eloquent\Builder|CareerWebform wherePlaceDateOfBirth($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @mixin \Eloquent
 */
class CareerWebform extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasMailing;

    public ?string $mailing_to = null;
    public ?string $mailing_subject = "Careers Application";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mailing_to = app(Site::class)->careers_mailing_list;
    }

    protected $appends = ['applied_career'];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function getAppliedCareerAttribute(){
        return $this->career->title;
    }

    public array $upload_attributes = [
        'cv'
    ];

    public function career(){
        return $this->belongsTo(Career::class);
    }
}

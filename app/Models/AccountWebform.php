<?php

namespace App\Models;

use App\Helpers\HasMailing;
use App\Settings\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\AccountWebform
 *
 * @property int $id
 * @property int $account_id
 * @property int $branch_id
 * @property int $currency_id
 * @property int $martial_status_id
 * @property int $scientific_status_id
 * @property int $accommodation_type_id
 * @property int $labor_sector_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $national_id
 * @property string $nation_id_place_of_issue
 * @property string $national_id_release_date
 * @property string $residence_id
 * @property string $residence_id_place_of_issue
 * @property string $residence_id_release_date
 * @property string $civil_status_number
 * @property string $civil_status_number_please_of_issue
 * @property string $civil_status_number_release_date
 * @property string $passport_number
 * @property string $passport_number_place_of_issue
 * @property string $passport_number_release_date
 * @property string $nationality_certificate
 * @property string $nationality_certificate_place_of_issue
 * @property string $nationality_certificate_release_date
 * @property string $mother_name
 * @property string $partner_name
 * @property string $governorate
 * @property string $area
 * @property string $place
 * @property string $alley
 * @property string $building_number
 * @property string $nearest_point
 * @property string $phone_number_1
 * @property string $phone_number_2
 * @property string $email
 * @property string|null $foreign_country
 * @property string|null $foreign_city
 * @property string|null $foreign_region
 * @property string|null $foreign_street_name
 * @property string|null $foreign_building_number
 * @property string|null $foreign_nearest_point
 * @property string|null $foreign_phone_number
 * @property string|null $foreign_mailbox
 * @property string|null $foreign_postal_code
 * @property string $company_name
 * @property string|null $institution_activity
 * @property string|null $institution_nationality
 * @property string|null $occupation
 * @property string|null $job_title
 * @property string $document
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dropdown $accommodationType
 * @property-read \App\Models\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Dropdown $laborSector
 * @property-read \App\Models\Dropdown $martialStatus
 * @property-read \App\Models\Dropdown $scientificStatus
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereAccommodationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereAlley($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereBuildingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereCivilStatusNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereCivilStatusNumberPleaseOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereCivilStatusNumberReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignBuildingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignMailbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignNearestPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereForeignStreetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereGovernorate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereInstitutionActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereInstitutionNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereLaborSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereMartialStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereMotherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNationIdPlaceOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNationalIdReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNationalityCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNationalityCertificatePlaceOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNationalityCertificateReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereNearestPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform wherePartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform wherePassportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform wherePassportNumberPlaceOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform wherePassportNumberReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform wherePhoneNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform wherePhoneNumber2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereResidenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereResidenceIdPlaceOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereResidenceIdReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereScientificStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereUpdatedAt($value)
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\Currency $currency
 * @property int $document_type_id
 * @property string $document_number
 * @property string $document_place_of_issue
 * @property string $document_release_date
 * @property-read \App\Models\Dropdown $documentType
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereDocumentPlaceOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereDocumentReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountWebform whereDocumentTypeId($value)
 * @mixin \Eloquent
 */
class AccountWebform extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

//    public function __construct(array $attributes = [])
//    {
//        parent::__construct($attributes);
//        $this->email = app(Site::class)->account_appliers_mailing_list;
//    }

    public array $upload_attributes = [
        'document'
    ];

    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function martialStatus(){
        return $this->belongsTo(Dropdown::class, 'martial_status_id', 'id')->where('category', Dropdown::MARTIAL_STATUS);
    }

    public function scientificStatus(){
        return $this->belongsTo(Dropdown::class, 'scientific_status_id', 'id')->where('category', Dropdown::SCIENTIFIC_STATUS);
    }

    public function accommodationType(){
        return $this->belongsTo(Dropdown::class, 'accommodation_type_id', 'id')->where('category', Dropdown::ACCOMMODATION_TYPE);
    }

    public function laborSector(){
        return $this->belongsTo(Dropdown::class, 'labor_sector_id', 'id')->where('category', Dropdown::LABOR_SECTOR_TYPE);
    }

    public function documentType(){
        return $this->belongsTo(Dropdown::class, 'document_type_id', 'id')->where('category', Dropdown::DOCUMENT_TYPE);
    }
}

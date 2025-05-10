<?php

namespace App\Http\Controllers;

use App\Helpers\HasProgressForm;
use App\Models\Account;
use App\Models\AccountWebform;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Dropdown;
use App\Models\Section;
use App\Settings\Site;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    use HasProgressForm;

    public function index($locale, Section $section){
        $items = Account::wherePromote(true)->get();

        $bottom_section = Dropdown::active()
            ->whereSlug('accounts-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->first();

        return $this->view('Accounts.index', compact('items', 'section', 'bottom_section'));
    }

    public function show($locale, Section $section, Account $account){
        return $this->view('Accounts.show', compact('account', 'section'));
    }

    private function getValidationRules($step){
        if ($step == 1)
            return [
//                'branch_id' => 'required|exists:branches,id',
                'account_id' => 'required|exists:accounts,id',
                'currency_id' => 'required|exists:currencies,id',
            ];

        if ($step == 2) {
            $validations = [
                'name_ar' => 'required',
                'name_en' => 'required',
                'document_type_id' => 'required|exists:dropdowns,id',
                'document_number' => 'required',
                'document_place_of_issue' => 'required',
                'document_release_date' => 'required',
                'mother_name' => 'required',
                'partner_name' => 'sometimes',
                'martial_status_id' => 'required|exists:dropdowns,id',
                'scientific_status_id' => 'required|exists:dropdowns,id'
            ];
            $document_type = Dropdown::find(\request()->get('document_type_id'));
            $martial_status =Dropdown::find(\request()->get('martial_status_id'));

            if ($document_type){
                $validations['document_number'] = 'required';
                $validations['document_number'] .= isset($document_type->validations['has_max_length']) ? '|digits:' . $document_type->validations['length'] : '';
            }

            if ($martial_status && isset($martial_status->validations['has_partner']) && $martial_status->validations['has_partner']){
                $validations['partner_name'] = 'required';
            }
            return $validations;
        }
        if ($step == 3)
            return [
                'accommodation_type_id' => 'required|exists:dropdowns,id',
                'governorate' => 'required',
                'area' => 'required',
                'place' => 'required',
                'alley' => 'required',
                'building_number' => 'required',
                'nearest_point' => 'required',
                'phone_number_1' => 'required|required|regex:/^[0-9+]*$/|max:11|size:11',
                'phone_number_2' => 'required|required|regex:/^[0-9+]*$/|max:11|size:11',
                'email' => 'required|email'
            ];

        if ($step == 4)
            return [
                'foreign_country' => 'nullable',
                'foreign_city' => 'nullable',
                'foreign_region' => 'nullable',
                'foreign_street_name' => 'nullable',
                'foreign_building_number' => 'nullable',
                'foreign_nearest_point' => 'nullable',
                'foreign_phone_number' => 'nullable|regex:/^[0-9+]*$/',
                'foreign_mailbox' => 'nullable|email',
                'foreign_postal_code' => 'nullable'
            ];

        if ($step == 5)
            return [
                'labor_sector_id' => 'required|exists:dropdowns,id',
                'company_name' => 'required',
                'institution_activity' => 'required',
                'institution_nationality' => 'required',
                'occupation' => 'required',
                'job_title' => 'required',
            ];

        if ($step == 6)
            return [
                'document' => 'required|file|mimes:doc,docx,rtf,txt,odt,pdf,jpg,png,jpeg|max:5120',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ];
        return [];
    }

    public function applyStep1(Request $request, $locale, Section $section, Account $account){
        $branches = Branch::where('is_atm', false)->get();
        $accounts = Account::all();
        $currencies = Currency::all();

        return self::validateForm(
            1, 6, $account,
            AccountWebform::class,
            'accounts', [
            'section' => $section,
            'account' => $account,
            'accounts' => $accounts,
            'currencies' => $currencies,
            'branches' => $branches
        ]);
    }
    public function applyStep2(Request $request, $locale, Section $section, Account $account){
        $martial_statuses = Dropdown::where('category', Dropdown::MARTIAL_STATUS)->get();
        $scientific_statuses = Dropdown::where('category', Dropdown::SCIENTIFIC_STATUS)->get();
        $document_types = Dropdown::where('category', Dropdown::DOCUMENT_TYPE)->get();

        return self::validateForm(
            2, 6, $account,
            AccountWebform::class,
            'accounts', [
            'section' => $section,
            'account' => $account,
            'scientific_statuses' => $scientific_statuses,
            'martial_statuses' => $martial_statuses,
            'document_types' => $document_types
        ]);
    }
    public function applyStep3(Request $request, $locale, Section $section, Account $account){
        $accommodation_types = Dropdown::where('category', Dropdown::ACCOMMODATION_TYPE)->get();
        return self::validateForm(
            3, 6, $account,
            AccountWebform::class,
            'accounts', [
            'section' => $section,
            'account' => $account,
            'accommodation_types' => $accommodation_types
        ]);
    }
    public function applyStep4($locale, Section $section, Account $account){
        return self::validateForm(
            4, 6, $account,
            AccountWebform::class,
            'accounts', [
            'section' => $section,
            'account' => $account,
        ]);
    }
    public function applyStep5($locale, Section $section, Account $account){
        $labor_sectors = Dropdown::where('category', Dropdown::LABOR_SECTOR_TYPE)->get();
        return self::validateForm(
            5, 6, $account,
            AccountWebform::class,
            'accounts', [
            'section' => $section,
            'account' => $account,
            'labor_sectors' => $labor_sectors
        ]);
    }
    public function applyStep6($locale, Section $section, Account $account){
        return self::validateForm(
            6, 6, $account,
            AccountWebform::class,
            'accounts', [
            'section' => $section,
            'account' => $account,
        ]);
    }

}

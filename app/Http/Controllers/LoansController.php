<?php

namespace App\Http\Controllers;

use App\Helpers\HasProgressForm;
use App\Models\Dropdown;
use App\Models\Loan;
use App\Models\LoanWebform;
use App\Models\Section;
use App\Settings\Site;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Psr\SimpleCache\InvalidArgumentException;

class LoansController extends Controller
{
    use HasProgressForm;

    public function index($locale, Section $section){
        $items = Loan::wherePromote(true)->get();

        $bottom_section = Dropdown::active()
            ->whereSlug('loans-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->first();

        return $this->view('Loans.index', compact('items', 'section', 'bottom_section'));
    }

    public function show($locale, Section $section, Loan $loan){
        return $this->view('Loans.show', compact('loan', 'section'));
    }

    private function getValidationRules($step){
        if ($step == 1)
            return [
                'name_ar' => 'required|string|min:15',
                'name_en' => 'required|string|min:15',
                'nationality' => 'required',
                'place_date_of_birth' => 'required',
                'address' => 'required',
                'phone_number' => 'required|regex:/^[0-9+]*$/',
                'preferred_method_of_communication' => 'required',
                'email' => 'required|email',
            ];

        if ($step == 2)
            return [
                'workplace' => 'required',
                'current_position' => 'required',
                'work_start_date' => 'required',
                'monthly_salary' => 'required|numeric',
                'extra_work' => 'required',
                'other_sources_of_income' => 'required'
            ];

        if ($step == 3)
            return [
                'loan_amount' => 'required|numeric',
                'payment_period' => 'required',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ];

        return [];
    }

    /**
     * @throws InvalidArgumentException
     * @throws ValidationException
     */
    public function applyStep1(Request $request, $locale, Section $section, Loan $loan){
        return self::validateForm(1, 3, $loan, LoanWebform::class, 'loans', ['section' => $section, 'loan' => $loan]);
    }

    public function applyStep2(Request $request, $locale, Section $section, Loan $loan){
        return self::validateForm(2, 3, $loan, LoanWebform::class, 'loans', ['section' => $section, 'loan' => $loan]);
    }

    public function applyStep3(Request $request, $locale, Section $section, Loan $loan){
        return self::validateForm(3, 3, $loan, LoanWebform::class, 'loans', ['section' => $section, 'loan' => $loan]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Helpers\HasProgressForm;
use App\Models\Branch;
use App\Models\Card;
use App\Models\CardWebform;
use App\Models\Dropdown;
use App\Models\Section;
use App\Settings\Site;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CardsController extends Controller
{
    use HasProgressForm;

    public function index($locale, Section $section){
        $cards = Card::wherePromote(true)->get();
        $bottom_section = Dropdown::active()
            ->whereSlug('cards-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->first();
        return $this->view('Cards.index', compact('cards', 'bottom_section', 'section'));
    }

    public function show($locale, Section $section, Card $card){
        return $this->view('Cards.show', compact('card', 'section'));
    }

    private function getValidationRules($step){
        if ($step == 1)
            return [
                'full_name_ar' => 'required',
                'full_name_en' => 'required',
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
                'card_identity' => 'required',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ];

        return [];
    }

    /**
     * @throws InvalidArgumentException
     * @throws ValidationException
     */
    public function applyStep1(Request $request, $locale, Section $section, Card $card){
        if ($card->form_type != Card::PROGRESS_FORM)
            throw new ModelNotFoundException();
        return self::validateForm(1, 3, $card, CardWebform::class, 'cards', ['section' => $section, 'card' => $card]);
    }

    public function applyStep2(Request $request, $locale, Section $section, Card $card){
        if ($card->form_type != Card::PROGRESS_FORM)
            throw new ModelNotFoundException();
        return self::validateForm(2, 3, $card, CardWebform::class, 'cards', ['section' => $section, 'card' => $card]);
    }

    public function applyStep3(Request $request, $locale, Section $section, Card $card){
        if ($card->form_type != Card::PROGRESS_FORM)
            throw new ModelNotFoundException();
        return self::validateForm(3, 3, $card, CardWebform::class, 'cards', ['section' => $section, 'card' => $card]);
    }

    public function apply(Request $request, $locale, Section $section, Card $card){
        if ($card->form_type != Card::SINGLE_FORM)
            throw new ModelNotFoundException();

        $branches = Branch::where('is_atm', 0)->get();

        if ($request->method() === "POST") {
            $data = $request->validate([
                'name_on_card' => 'required',
                'branch_id' => 'required|exists:branches,id',
                'date' => 'required|date|after_or_equal:today',
                'account_number' => 'required',
                'full_name' => 'required',
                'date_of_birth' => 'required',
                'phone_number' => 'required|regex:/^[0-9+]*$/',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ]);
            $data['card_id'] = $card->id;
            CardWebform::create(\Arr::except($data, 'g-recaptcha-response'));
            return back()->with('success', __("site.Application Has Been Submitted Successfully"));
        }

        return $this->view('Cards.apply-form-single', compact('card', 'branches'));
    }
}

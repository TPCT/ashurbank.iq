<?php

namespace App\Http\Controllers;

use App\Helpers\HasProgressForm;
use App\Models\Block;
use App\Models\Career;
use App\Models\CareerWebform;
use App\Models\Dropdown;
use App\Settings\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Attributes\Rule;

class CareersController extends Controller
{
    use HasProgressForm;

    public function index()
    {
        $search = \request('search');
        $location = \request('location');

        $careers = Career::active()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($location, function ($query) use ($location) {
                $query->where('location', 'like', '%' . $location . '%');
            })
            ->paginate(app(Site::class)->careers_page_size);

        return $this->view('Careers.index', compact(
            'careers', 'search', 'location'
        ));
    }

    public function show($locale, Career $career)
    {
        return $this->view('Careers.view', compact('career'));
    }

    private function getValidationRules($step){
        if ($step == 1)
            return [
                'name' => 'required',
                'place_date_of_birth' => 'required',
                'email' => 'required|email',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required|regex:/^[0-9+]*$/',
            ];

        if ($step == 2)
            return [
                'address' => 'required',
                'country' => 'required',
                'city' => 'required',
            ];

        if ($step == 3)
            return [
                'qualifications' => 'required',
                'specialization' => 'required',
                'scientific_expertise' => 'required',
                'years_of_experience' => 'required',
                'cv' => 'required|file|mimes:doc,docx,rtf,txt,odt,pdf,jpg,png,jpeg|max:5120',
//                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ];

        return [];
    }


    public function applyStep1(Request $request, $locale, Career $career){
        return self::validateForm(1, 3, $career, CareerWebform::class, 'careers', ['career' => $career]);
    }
    public function applyStep2(Request $request, $locale, Career $career){
        return self::validateForm(2, 3, $career, CareerWebform::class, 'careers', ['career' => $career]);
    }

    public function applyStep3(Request $request, $locale, Career $career){
        return self::validateForm(3, 3, $career, CareerWebform::class, 'careers', ['career' => $career]);
    }
}

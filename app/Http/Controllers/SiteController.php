<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use App\Models\Account;
use App\Models\AnnualGeneral;
use App\Models\Block;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Card;
use App\Models\Career;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\Dropdown;
use App\Models\Faq;
use App\Models\FinancialStatement;
use App\Models\Loan;
use App\Models\MedicalNetworkCategory;
use App\Models\Menu;
use App\Models\News;
use App\Models\Page;
use App\Models\Section;
use App\Models\ShareHolder;
use App\Models\Slider;
use App\Models\TakafulProduct;
use App\Models\TeamMember;
use App\Settings\Site;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class SiteController extends Controller
{
    public function index(Request $request){

        $banking_services_slider = Slider::active()
            ->whereCategory(Slider::HOMEPAGE_SLIDER)
            ->whereSlug('we-offer-banking-services-for-everyone')
            ->first();

        $homepage_first_section = Dropdown::active()
                ->whereCategory(Dropdown::BLOCK_CATEGORY)
                ->whereSlug('homepage-first-section')
                ->first()
                ?->blocks()->first();

        $homepage_second_section = Dropdown::active()
                ->whereCategory(Dropdown::BLOCK_CATEGORY)
                ->whereSlug('homepage-second-section')
                ->first()
                ?->blocks()->first();

        $homepage_third_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-third-section')
            ->first()
            ?->blocks()->first();

        $homepage_fourth_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-fourth-section')
            ->first()
            ?->blocks()->first();

        $homepage_fifth_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-fifth-section')
            ->first()
            ?->blocks()->first();

        $homepage_sixth_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-sixth-section')
            ->first()
            ?->blocks()->first();

        $homepage_faqs = Faq::active()
            ->where('promote_to_homepage', true)
            ->where('is_video', false)
            ->limit(7)
            ->get();

        $homepage_faqs_videos = Faq::active()
            ->where('promote_to_homepage', true)
            ->where('is_video', true)
            ->limit(2)
            ->get();

        $homepage_seventh_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-seventh-section')
            ->first()
            ?->blocks()->first();

        return $this->view('Site.homepage', [
            'banking_services_slider' => $banking_services_slider,
            'homepage_first_section' => $homepage_first_section,
            'homepage_second_section' =>  $homepage_second_section,
            'homepage_third_section' =>  $homepage_third_section,
            'homepage_fourth_section' =>  $homepage_fourth_section,
            'homepage_fifth_section' =>  $homepage_fifth_section,
            'homepage_sixth_section' =>  $homepage_sixth_section,
            'homepage_faqs' => $homepage_faqs,
            'homepage_faqs_videos' => $homepage_faqs_videos,
            'homepage_seventh_section' => $homepage_seventh_section
        ]);
    }

    public function aboutUs(Request $request){
        $about_us_first_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('about-us-first-section')
            ->first()
            ?->blocks()->first();

        $about_us_second_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('about-us-second-section')
            ->first()
            ?->blocks()->first();

        $about_us_third_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('about-us-third-section')
            ->first()
            ?->blocks()->first();

        $about_us_fourth_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('about-us-fourth-section')
            ->first()
            ?->blocks()->first();

        $about_us_fifth_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('about-us-fifth-section')
            ->first()
            ?->blocks()->first();

        $board_of_directors = TeamMember::active()->get();

        return $this->view('Site.about-us', [
            'about_us_first_section' => $about_us_first_section,
            'about_us_second_section' => $about_us_second_section,
            'about_us_third_section' => $about_us_third_section,
            'about_us_fourth_section' =>  $about_us_fourth_section,
            'about_us_fifth_section' =>  $about_us_fifth_section,
            'board_of_directors' => $board_of_directors,
        ]);
    }

    public function faqs(Request $request)
    {
        $search = \request('search');

        $faqs = Faq::active()
            ->where('is_video', false)
            ->where(function ($query) use ($search){
                if ($search){
                    $query->where('title', 'like', "%{$search}%");
                    $query->orWhere('description', 'like', "%{$search}%");
                }
            })
            ->get();

        $videos = Faq::active()
            ->where('is_video', true)
            ->where(function ($query) use ($search){
                if ($search){
                    $query->where('title', 'like', "%{$search}%");
                    $query->orWhere('description', 'like', "%{$search}%");
                }
            })
            ->get();
        return $this->view('Site.faqs', compact('faqs', 'videos'));
    }


    public function filter(){
        $keyword = \request('search', '');
        $model = \request('model', '');
        $page = \request('page', 0);
        $prefix = "\\App\\Models\\";

        $models = [
            'Account' => ['title', 'second_title', 'description', 'content'],
            'Card' => ['title', 'description', 'content'],
            'Career' => ['title', 'location', 'description', 'qualifications', 'benefits', 'desirable'],
            'Loan' => ['title', 'second_title', 'description', 'content'],
            'News' => ['title', 'description', 'content'],
            'Page' => ['title', 'description', 'content']
        ];

        $search_results = [];

        if ($model)
            $models = \Arr::only($models, [ucfirst($model)]);

        foreach ($models as $model_name => $keys){
            $model_class = "App\\Models\\" . $model_name;
            $search_results[$model_name] = $model_class::results($keys);
            if (!count($search_results[$model_name]))
                unset($search_results[$model_name]);
        }

        return $this->view('filter', compact('search_results', 'keyword'));
    }

    public function sitemap(){
        return $this->view('Site.sitemap', [
            'menu' => Menu::active()->whereCategory(Menu::SITE_MAP_MENU)->first()
        ]);
    }

    public function contactUs(Request $request){
        $branches = Branch::active()->limit(app(Site::class)->branches_page_size)->get();
        if ($request->method() == "POST") {
            $data = $request->validate([
                'name' => 'required|min:10|regex:/^[^0-9]*$/i|max:255',
                'email' => 'required|email',
                'subject' => 'required|min:10',
                'message' => 'required|min:20|max:255',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ]);

            unset($data['g-recaptcha-response']);
            $model = ContactUs::create($data);
            $model->save();
            return redirect()->route('site.contact-us')->with('success', __("site.Application Has Been Submitted Successfully"));
        }
        return $this->view('Site.contact-us', compact(
            'branches'
        ));
    }

    public function show(): bool|\Illuminate\Http\JsonResponse|string
    {
        $segments = \request()->segments();
        $prefix = implode(
            '/',
            array_slice($segments, \request()->route()->hasParameter('section') ? 2 : 1, -1)
        );

        $prefix = $prefix ?: null;
        $slug = last($segments);


        $page = Page::active()
            ->directAccess()
            ->whereSlug($slug)
            ->wherePrefix($prefix)
//            ->whereDoesntHave('sections')
            ->first();

//        if (!$page){
//            $prefix = implode('/', array_slice($segments, 2, -1));
//            $prefix = $prefix ?: null;
//
//            $page = Page::active()
//                        ->directAccess()
//                        ->whereSlug($slug)
//                        ->wherePrefix($prefix)
//                        ->first();
//        }

        if (!$page)
            return (new SectionController())->index(app()->getLocale(), \request()->segment(2));

        $view = strtolower(explode(' ', $page->view)[0]);
        return $this->view('Pages.' . $view, compact('page'));
    }

    public function currencyExchange(Request $request)
    {
        $currencies = Currency::all();
        $total = 0;
        $data = [
            'from_currency' => 0,
            'to_currency' => 0,
            'amount' => 0
        ];

        if ($request->isMethod('post')){
            $data = $request->validate([
                'amount' => 'required|numeric|min:0',
                'from_currency' => 'required|exists:currencies,id',
                'to_currency' => 'required|exists:currencies,id',
                'g-recaptcha-response' => app(Site::class)->enable_captcha ? 'required|captcha' : 'nullable'
            ]);

            $from_currency = Currency::find($data['from_currency']);
            $to_currency = Currency::find($data['to_currency']);
            $transaction_rate = $from_currency->rate / $to_currency->rate;
            $total = $transaction_rate * $data['amount'];
        }


        return $this->view('Site.currency-exchange', array_merge([
            'currencies' => $currencies,
            'total' => $total,
        ], \Arr::except($data,'g-captcha-response')));
    }
}

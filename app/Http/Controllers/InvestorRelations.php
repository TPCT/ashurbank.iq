<?php

namespace App\Http\Controllers;

use App\Models\AnnualGeneral;
use App\Models\Dropdown;
use App\Models\FinancialStatement;
use App\Models\ShareHolder;
use App\Settings\Site;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class InvestorRelations extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $investor_relations_first_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('investor-relations-first-section')
            ->first()
            ?->blocks()->first();

        $investor_relations_second_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('investor-relations-second-section')
            ->first()
            ?->blocks()->first();

        $investor_relations_third_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('investor-relations-third-section')
            ->first()
            ?->blocks()->first();

        return $this->view('Investor-Relations.index', [
            'investor_relations_first_section' => $investor_relations_first_section,
            'investor_relations_second_section' => $investor_relations_second_section,
            'investor_relations_third_section' => $investor_relations_third_section
        ]);
    }

    public function financialStatements(){
        $financial_information_first_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('financial-statements-first-section')
            ->first()
            ?->blocks()->first();

        $keyword = \request('search');
        $year = \request('year');
        $page = \request('page');


        $financial_statements = FinancialStatement::active()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('published_at', '=', $year);
            })
            ->when($page, function ($query) use ($page) {
                $query->offset(($page - 1) * app(Site::class)->financial_statements_page_size);
            })
            ->paginate(
            app(Site::class)->financial_statements_page_size
        );

        return $this->view('Investor-Relations.financial-information', [
            'financial_information_first_section' => $financial_information_first_section,
            'financial_statements' => $financial_statements,
        ]);
    }

    public function annualGenerals(){
        $annual_generals_first_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('annual-generals-first-section')
            ->first()
            ?->blocks()->first();


        $keyword = \request('search');
        $year = \request('year');
        $page = \request('page');


        $annual_generals = AnnualGeneral::active()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('published_at', '=', $year);
            })
            ->when($page, function ($query) use ($page) {
                $query->offset(($page - 1) * app(Site::class)->financial_statements_page_size);
            })
            ->paginate(
                app(Site::class)->annual_general_page_size
            );


        return $this->view('Investor-Relations.annual-generals', [
            'annual_generals_first_section' => $annual_generals_first_section,
            'annual_generals' => $annual_generals,
        ]);
    }

    public function shareholders(){
        $shareholders_first_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('shareholders-first-section')
            ->first()
            ?->blocks()->first();

        if (\request('show_all'))
            $shareholders = ShareHolder::active()->get();
        else
            $shareholders = ShareHolder::active()->limit(app(Site::class)->shareholders_page_size)->get();

        return $this->view('Investor-Relations.shareholders', [
            'shareholders_first_section' => $shareholders_first_section,
            'shareholders' => $shareholders,
        ]);
    }
}

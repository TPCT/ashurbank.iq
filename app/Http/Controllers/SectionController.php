<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index($locale, $section){
        $section = Section::active()->whereSlug($section)->firstOrFail();

        $first_section = Dropdown::
            whereSlug('section-page-first-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->section($section->slug)
            ->first();
        $second_section = Dropdown::
            whereSlug('section-page-second-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->section($section->slug)
            ->first();
        $third_section = Dropdown::
            whereSlug('section-page-third-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->section($section->slug)
            ->first();
        $fourth_section = Dropdown::
            whereSlug('section-page-fourth-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->section($section->slug)
            ->first();
        $fifth_section = Dropdown::
            whereSlug('section-page-fifth-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->section($section->slug)
            ->first();

        $view = strtolower(explode(' ', $section->view)[0]);
        return $this->view('Section.' . $view, compact(
            'section',
            'first_section',
            'second_section',
            'third_section',
            'fourth_section',
            'fifth_section',
        ));
    }
}

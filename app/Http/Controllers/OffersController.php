<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Page;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function index(){
        $first_section = Dropdown::active()
            ->whereSlug('offers-page-first-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->first();
        $second_section = Dropdown::active()
            ->whereSlug('offers-page-second-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->first();

        return $this->view('Offers.index', compact('first_section', 'second_section'));
    }

    public function show($locale, Page $page){
        return $this->view('Offers.view', compact('page'));
    }
}

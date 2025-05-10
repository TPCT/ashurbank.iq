<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Section;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index($locale, Section $section){
        $items = Transfer::get();
        $bottom_section = Dropdown::active()
            ->whereSlug('transfers-section')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->section($section->slug)
            ->first();
        return $this->view('Transfer.index', compact('items', 'section', 'bottom_section'));
    }

    public function show($locale, Section $section, Transfer $transfer){
        if ($transfer->view == Transfer::BANK_TRANSFER_VIEW)
            return $this->view('Transfer.bank', compact('transfer'));
        return $this->view('Transfer.money-gram', compact('transfer'));
    }
}

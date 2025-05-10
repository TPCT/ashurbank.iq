<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Dropdown;
use App\Models\Loan;
use App\Models\Section;
use App\Settings\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalculatorsController extends Controller
{

    public function index(){
        $calculators = Dropdown::active()
            ->whereSlug('calculators-types')
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->first()
            ?->blocks()
            ->get();

        return $this->view('Calculators.index', compact('calculators'));
    }


    public function deposits(Request $request){
        $currencies = Currency::all();

        $final_amount = 0;
        $selected_currency = "";
        $deposit_amount = 0;
        $interest_amount = 0;
        $interest_rate = app(Site::class)->deposits_interest_rate;
        $start_date = null;
        $end_date = null;

        if ($request->method() == "POST"){
            $data = $request->validate([
                'deposit_amount' => 'required|numeric|min:0',
                'currency_id' => 'required|exists:currencies,id',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
            ]);

            $selected_currency = Currency::find($request->currency_id)->title;
            $number_of_months = Carbon::parse($request->end_date)->diffInMonths(Carbon::parse($request->start_date));

            $interest_amount = $request->deposit_amount * $number_of_months * app(Site::class)->deposits_interest_rate / (12 * 100);
            $interest_rate = app(Site::class)->deposits_interest_rate;
            $deposit_amount = $request->deposit_amount;
            $final_amount = $deposit_amount + $interest_amount;

            $data = array_merge($data, compact('currencies', 'selected_currency', 'deposit_amount', 'final_amount', 'interest_rate', 'interest_amount'));
            return $this->view('Calculators.deposits', $data);
        }

        return $this->view('Calculators.deposits', compact(
            'currencies',
            'selected_currency',
            'deposit_amount',
            'final_amount',
            'interest_rate',
            'interest_amount',
            'start_date',
            'end_date'
        ));
    }

    public function loans(Request $request, $locale, Section $section){
        $loan_payment_types = Dropdown::whereCategory(Dropdown::LOAN_PAYMENT_METHOD)->get();
        $currencies = Currency::all();
        $loans = Loan::all();

        $loan_amount = 0;
        $selected_currency = "";
        $monthly_payment = 0;
        $total_interest_amount = 0;
        $duration = 0;


        if (request()->method() == "POST"){
            $request->validate([
                'loan_payment_type_id' => 'required|exists:dropdowns,id',
                'loan_amount' => 'required|numeric|min:0',
                'currency_id' => 'required|exists:currencies,id',
                'duration' => 'required|numeric|min:0',
                'loan_id' => 'required|exists:loans,id',
            ]);

            $interest_rate = Loan::find($request->loan_id)->interest_rate / 100;
            $number_of_months = $request->duration * 12;

            $total_interest_amount = $request->loan_amount * $interest_rate * $number_of_months / 12;
            $monthly_payment = $number_of_months ?  ($total_interest_amount + $request->loan_amount) / $number_of_months : 0;

            $data = array_merge([
                'loan_amount' => $loan_amount,
                'currencies' => $currencies,
                'loan_payment_types' => $loan_payment_types,
                'loans' => $loans,
                'duration' => $duration,
                'monthly_payment' => \Number::format($monthly_payment, 1),
                'total_interest_amount' => $total_interest_amount,
                'selected_currency' => $selected_currency,
                'section' => $section
            ], $request->all());

            return $this->view('Calculators.loans', $data);
        }

        return $this->view('Calculators.loans', [
            'loan_amount' => $loan_amount,
            'currencies' => $currencies,
            'loan_payment_types' => $loan_payment_types,
            'loans' => $loans,
            'duration' => $duration,
            'monthly_payment' => $monthly_payment,
            'total_interest_amount' => $total_interest_amount,
            'selected_currency' => $selected_currency,
            'section' => $section
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Settings\Site;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    public function index(){
        $branches = Branch::active();

        $city_id = \request('city_id');

        $branches
            ->when(\request('is_atm'), function ($query) {
                return $query->where('is_atm', true);
            })
            ->when(\request('is_branch'), function($query){
                return $query->where('is_atm', false);
            })
            ->when($city_id, function($query) use ($city_id){
                return $query->where('city_id', $city_id);
            });

        $branches_count = (clone $branches)->where('is_atm', false)->count();
        $atms_count = (clone $branches)->where('is_atm', true)->count();

        $cities = City::active()->get();
        return $this->view('Branches.index', compact('branches', 'cities', 'branches_count', 'atms_count'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Compatibilities_suggestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompatibilitiesSuggestionsController extends Controller
{

    public function index() {
        return view('content.suggestions.index');
    }

    public function load() {
        $suggestions = DB::table('compatibilities_suggestions')
        ->join('technicians', 'compatibilities_suggestions.sugg_tech', '=', 'technicians.tech_id')
        ->join('users', 'compatibilities_suggestions.sugg_act_by', '=', 'users.id')
        ->join('compatibility_categories', 'compatibilities_suggestions.sugg_category', '=', 'compatibility_categories.category_id')
        ->orderBy('sugg_act_time', 'desc')->limit(15)->offset(0)->get();
        echo json_encode($suggestions);
    }

    public function store(Request $request) {
        // return $request;
        $status = Compatibilities_suggestions::create([
            'sugg_status' => 0,
            'sugg_points' => '',
            'sugg_act_note' => '',
            'sugg_act_time' => now(),
            'sugg_category' => $request->cate_id,
            'sugg_tech'  => $request->technician_id,
            'sugg_act_by' => auth()->user()->id
        ]);
        $status->models()->attach(1);
    }

}
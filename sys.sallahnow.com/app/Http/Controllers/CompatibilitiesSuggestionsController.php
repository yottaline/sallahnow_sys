<?php

namespace App\Http\Controllers;

use App\Models\Compatibilities_suggestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompatibilitiesSuggestionsController extends Controller
{

    public function index()
    {
        return view('content.suggestions.index');
    }

    public function load(Request $request) 
    {
    
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;

        echo json_encode(Compatibilities_suggestions::fetch(0, $params, $limit, $listId));
    }

    public function store(Request $request) {
        
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
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
        $suggestions = Compatibilities_suggestions::orderBy('created_at', 'desc')->limit(15)->get();
        echo json_encode($suggestions);
    }

    public function store(Request $request) {
        return $request;
        $status = Compatibilities_suggestions::create([
            'status' => 0,
            'act_not' => '',
            'act_time' => now(),
            'category_id' => $request->cate_id,
            'technician_id'  => $request->technician_id,
            'user_id' => 1
        ]);
        $status->models()->attach(1);
    }

    public function getCateName() {
        $cate_name = DB::table('compatibility_categories')
        ->join('compatibilities_suggestions', 'compatibility_categories.id', '=', 'compatibilities_suggestions.category_id')
        ->orderBy('compatibilities_suggestions.created_at', 'desc')
        ->get();
        echo json_encode($cate_name);
    }

    public function getTechnicianName() {
        $technician_name = DB::table('technicians')
        ->join('compatibilities_suggestions', 'technicians.id', '=', 'compatibilities_suggestions.technician_id')
        ->orderBy('compatibilities_suggestions.created_at', 'desc')
        ->get();
        echo json_encode($technician_name);
    }
    public function getUserName() {
        $user_name = DB::table('users')
        ->join('compatibilities_suggestions', 'users.id', '=', 'compatibilities_suggestions.user_id')
        ->orderBy('compatibilities_suggestions.created_at', 'desc')
        ->get();
        echo json_encode($user_name);
    }
}
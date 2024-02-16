<?php

namespace App\Http\Controllers;

use App\Models\Compatibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompatibilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('content.compatibilities.index');
    }

    public function load(){
        $compatibiliy = Compatibility::all();
        echo json_encode($compatibiliy);
    }

    public function submit(Request $request){
        $parts = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $part = json_encode($parts);

        $id = $request->comp_id;
        if(!$id) {
          $status = Compatibility::create([
                'part'  => $part,
                'compatibility_categorie_id' => $request->cate_id,
            ]);

            $status->models()->attach($request->model_id);
            $id = $status->id;
        }else {
            $status = Compatibility::where('id', $id)->update([
                'part'  => $part,
                'compatibility_categorie_id' => $request->cate_id,
            ]);
        };

        $record = Compatibility::where('id', $id)->get();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function getCateName() {
        $cate_name = DB::table('compatibility_categories')
        ->join('compatibilities', 'compatibility_categories.id', '=', 'compatibilities.compatibility_categorie_id')
        ->orderBy('compatibilities.created_at', 'desc')
        ->get();
        echo json_encode($cate_name);
    }
}
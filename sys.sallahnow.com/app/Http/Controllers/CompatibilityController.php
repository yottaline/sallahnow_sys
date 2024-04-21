<?php

namespace App\Http\Controllers;

use App\Models\Compatibility;
use App\Models\Compatibility_categorie;
use App\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompatibilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $categories = Compatibility_categorie::all();
        $models     = Models::all();
        
        return view('content.compatibilities.index', compact('categories', 'models'));
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;
        
        echo json_encode(Compatibility::fetch(0, $params,$limit, $listId));
    }

    public function submit(Request $request){
        
        $parts = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $part = json_encode($parts);

        $id = $request->comp_id;
        if(!$id) 
        {
          $status = Compatibility::create([
                'compat_part'  => $part,
                'compat_category' => $request->cate_id,
            ]);

            $status->models()->attach($request->model_id);
            $id = $status->id;
        }else {
            $status = Compatibility::where('id', $id)->update([
                'compatibility_part'  => $part,
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
        ->join('compatibilities', 'compatibility_categories.category_id', '=', 'compatibilities.compat_category')
        ->orderBy('compatibilities.compat_id', 'desc')
        ->get();

        echo json_encode($cate_name); 
    }
}
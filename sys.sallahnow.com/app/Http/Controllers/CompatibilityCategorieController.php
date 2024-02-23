<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compatibility_categorie;
use Illuminate\Support\Facades\DB;

class CompatibilityCategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function load() {
        $categories = Compatibility_categorie::limit(15)->offset(0)->get();
        echo json_encode($categories);
    }

    public function submit(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        $id = $request->cate_id;
        if(!$id){
            $status = Compatibility_categorie::create([
                'category_name' => $request->name
            ]);
        $id = $status->category_id;
        }else{
            $status = Compatibility_categorie::where('category_id', $id)->update([
                'category_name' => $request->name
            ]);
        }
        $record = Compatibility_categorie::where('category_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }
}
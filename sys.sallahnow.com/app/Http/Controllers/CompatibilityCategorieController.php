<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compatibility_categorie;

class CompatibilityCategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function load() {
        $compatibility_categories = Compatibility_categorie::orderBy('created_at', 'desc')->limit(15)->get();
        echo json_encode($compatibility_categories);
    }

    public function submit(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        $id = $request->cate_id;
        if(!$id){
            $status = Compatibility_categorie::create([
                'cate_name' => $request->name
            ]);
        $id = $status->id;
        }else{
            $status = Compatibility_categorie::where('id', $id)->update([
                'cate_name' => $request->name
            ]);
        }
        $record = Compatibility_categorie::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }
}

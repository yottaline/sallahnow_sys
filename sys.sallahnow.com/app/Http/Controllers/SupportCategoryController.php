<?php

namespace App\Http\Controllers;

use App\Models\Support_category;
use Illuminate\Http\Request;

class SupportCategoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index() {
        return view('content.supports.index');
    }

    public function load() {
        $categories = Support_category::limit(10)->offset(0)->get();
        echo json_encode($categories);
    }

    public function submit(Request $request) {
        $request->validate([
            'name_en'  => 'required | string',
            'name_ar'  => 'required | string'
        ]);

        $names =  ['en' => $request->name_en, 'ar' => $request->name_ar];
        $category_name = json_encode($names);

        $category_id = $request->cate_id;
        if(!$category_id) {
            $status = Support_category::create([
                'category_name' => $category_name
            ]);
            $category_id = $status->id;
        }
        else{
            $status = Support_category::where('category_id', $category_id)
                      ->update(['category_name' => $category_name]);
        }

        $record =  Support_category::where('category_id', $category_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function updateCost(Request $request) {
        $request->validate([
            'cost' => 'required|numeric'
        ]);
        $category_id = $request->cate_id;
        $status = Support_category::where('category_id', $category_id)->update([
            'category_cost'  => $request->cost
        ]);

        $record = Support_category::where('category_id', $category_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }
}
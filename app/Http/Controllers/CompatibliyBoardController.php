<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compatibliy_board;

class CompatibliyBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function load(Request $request)
    {
        echo json_encode(Compatibliy_board::fetch());
    }

    public function submit(Request $request)
    {
       $param = $request->validate(['board_name'=>'required']);

        $id = $request->board_id;

        $result = Compatibliy_board::submit($param, $id);

        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Compatibliy_board::fetch($result) : []
        ]);
    }
}
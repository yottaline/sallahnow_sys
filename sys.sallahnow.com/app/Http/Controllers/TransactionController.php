<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        return view('content.transactions.index');
    }

    public function load(Request $request)
    {
        $param  = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $listId = $request->list_id;
        echo json_encode(Transaction::fetch(0, $param, $limit, $listId));
    }

    public function submit(Request $request)
    {
        $id = $request->tran_id;
        $param = [
            'trans_method'    => $request->method,
            'trans_amount'    => $request->amount,
            'trans_process'   => $request->process,
            'trans_create_by' => auth()->user()->id,
            'trans_tech'      => $request->technician_id,
        ];

        if(!$id) {
            $param['trans_ref'] = strtoupper($this->uniqidReal());
        }
        
        $result = Transaction::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Transaction::fetch($id) : [],
        ]);
    }

    // public function technicianName() {
    //     $technician_name = DB::table('technicians')
    //     ->join('transactions', 'technicians.tech_id', '=', 'transactions.technician_id')
    //     ->orderBy('transactions.created_at', 'desc')
    //     ->get();
    //     echo json_encode($technician_name);
    // }

    // public function changeProcess(Request $request) 
    // {
    //     return 1;
    // }

    public function profile($reference) 
    {
        $param =  ['q' => $reference];
        $transactions = Transaction::fetch(0, $param);

        return view('content.transactions.profile', $transactions[0]);
    }


    private function uniqidReal($lenght = 8)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            // throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}
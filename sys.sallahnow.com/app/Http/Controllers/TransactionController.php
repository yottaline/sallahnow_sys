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

    public function index() {
        return view('content.transactions.index');
    }

    public function load() {
        $transactions = Transaction::orderBy('created_at', 'desc')->limit(15)->get();
        echo json_encode($transactions);
    }

    public function submit(Request $request) {

        $id = $request->tran_id;
        $param = [
            'trans_method'    => $request->method,
            'trans_amount'    => $request->amount,
            'trans_process'   => $request->process,
            'trans_create_by' => auth()->user()->id,
            'technician_id' => $request->technician_name,
        ];

        if(!$id) {
            $param['reference'] = strtoupper($this->uniqidReal());
            $status = Transaction::create($param);
            $id = $status->id;
        }
        else {
            $status = Transaction::where('id', $id)->update($param);
        }

        $record = Transaction::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function technicianName() {
        $technician_name = DB::table('technicians')
        ->join('transactions', 'technicians.id', '=', 'transactions.technician_id')
        ->orderBy('transactions.created_at', 'desc')
        ->get();
        echo json_encode($technician_name);
    }

    public function changeProcess(Request $request) {
        return 1;
    }

    public function profile($reference) {
        $transactions = Transaction::where('reference', $reference)->get();
        return view('content.transactions.profile');
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

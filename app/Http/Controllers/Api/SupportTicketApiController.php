<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Support_category;
use App\Models\Support_replie;
use App\Models\Support_ticket;
use App\ResponseApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SupportTicketApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        return $this->middleware(['auth:technician-api', 'check_device_token']);
    }

    public function getTickets()
    {
        $tickets = Support_ticket::fetch();

        return $this->returnData('data', $tickets);
    }

    public function addTicket(Request $request)
    {

        $data = $request->validate([
            'brand_id'       => 'required | numeric',
            'model_id'       => 'required | numeric',
            'category_id'    => 'required | numeric',
            'tech_id'        => 'required | numeric',
            'text'           => 'required | string',
        ]);

        $param = [
            'ticket_brand'    => $request->brand_id,
            'ticket_model'    => $request->model_id,
            'ticket_category' => $request->category_id,
            'ticket_tech'     => $request->tech_id,
            'ticket_context'  => $request->text,
        ];

        $cate_id = $request->category_id;
        $cost = Support_category::fetch($cate_id);

        if(!$cost) return $this->returnError('No category', 107);

        $param['ticket_code']   = strtoupper($this->uniqidReal());
        $param['ticket_cost']   = $cost->category_cost;
        $param['ticket_create'] = Carbon::now();

        $result = Support_ticket::submit($param, null);

        $ticket = $result ? Support_ticket::fetch($result) : [];

        return $this->returnData('data', $ticket);
    }

    public function gtReplies(Request $request)
    {
        $id  = $request->ticket_id;
        $params[] = ['reply_ticket', $id];
        $replies = Support_replie::fetch(0, $params);
        return $this->returnData('data', $replies);
    }

    public function addReplie(Request $request)
    {

        $data = $request->validate([
            'reply_ticket'  => 'required | numeric',
            'reply_tech'    => 'required | numeric',
            'reply_context' => 'required | string'
        ]);

        $data['reply_create'] = Carbon::now();
        $tickId = $request->reply_ticket;
        $param = ['ticket_status' => 2];
        Support_ticket::submit($param, $tickId);

        $result = Support_replie::submit($data);


        $replie = $result ? Support_replie::fetch($result) : [];

        return $this->returnData('data', $replie);
    }

    private function uniqidReal($lenght = 12)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}

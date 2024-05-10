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
            'ticket_brand'       => 'required | numeric',
            'ticket_model'       => 'required | numeric',
            'ticket_category'    => 'required | numeric',
            'ticket_tech'        => 'required | numeric',
            'ticket_context'     => 'required | string',
        ]);

        $cate_id = $request->ticket_category;
        $cost = Support_category::fetch($cate_id);
        if(!$cost) return $this->returnError('No category', 107);

        $data['ticket_code']   = strtoupper($this->uniqidReal());
        $data['ticket_cost']   = $cost->category_cost;
        $data['ticket_create'] = Carbon::now();

        $result = Support_ticket::submit($data, null);

        $ticket = $result ? Support_ticket::fetch($result) : [];

        return $this->returnData('ticket', $ticket);
    }

    public function gtReplies($ticket_id)
    {
        $params[] = ['reply_ticket', $ticket_id];
        $replies = Support_replie::fetch(0, $params);
        return $this->returnData('replies', $replies);
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

        return $this->returnData('replie', $replie);
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
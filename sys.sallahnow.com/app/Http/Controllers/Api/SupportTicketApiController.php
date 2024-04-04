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

    public function getTickets() {
        $tickets = DB::table('support_tickets')
        ->join('brands', 'support_tickets.ticket_brand', '=', 'brands.brand_id')
        ->join('models', 'support_tickets.ticket_model', '=', 'models.model_id')
        ->join('support_categories', 'support_tickets.ticket_category', '=', 'support_categories.category_id')
        ->join('technicians', 'support_tickets.ticket_tech', '=', 'technicians.tech_id')
        ->get();

        return $this->returnData('tickets', $tickets);
    }

    public function addTicket(Request $request) {

        $data = $request->validate([
            'ticket_brand'       => 'required | numeric',
            'ticket_model'       => 'required | numeric',
            'ticket_category'    => 'required | numeric',
            'ticket_tech'        => 'required | numeric',
            'ticket_context'     => 'required | string',
        ]);

        $cost = Support_category::where('category_id', $request->ticket_category)->first();
        if(!$cost)
        {
            return $this->returnError('No category', 107);
        }

        $data['ticket_code']   = strtoupper($this->uniqidReal());
        $data['ticket_cost']   = $cost->category_cost;
        $data['ticket_create'] = Carbon::now();

        $status = Support_ticket::create($data);
        $ticket_id = $status->id;

        $ticket = Support_ticket::where('ticket_id', $ticket_id)->first();
        return $this->returnData('ticket', $ticket);
    }

    public function gtReplies($ticket_id) {

        $replies = Support_replie::where('reply_ticket', $ticket_id)->get();
        return $this->returnData('replies', $replies);
    }

    public function addReplie(Request $request) {

        $data = $request->validate([
            'reply_ticket'  => 'required | numeric',
            'reply_tech'    => 'required | numeric',
            'reply_context' => 'required | string'
        ]);

        $data['reply_create'] = Carbon::now();

        Support_ticket::where('ticket_id', $request->reply_ticket)->update(['ticket_status' => 2]);

        $status = Support_replie::create($data);

        $reply_id = $status->id;

        $replie = Support_replie::where('reply_id', $reply_id)->first();

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
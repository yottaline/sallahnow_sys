<?php

namespace App\Http\Controllers;

use App\Models\Support_attachment;
use App\Models\Support_replie;
use App\Models\Support_ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportTicketController extends Controller
{
    public function index() {
        return view('content.supports.tickets');
    }

    public function load() {
        $tickets = DB::table('support_tickets')
        ->join('brands', 'support_tickets.ticket_brand', '=', 'brands.brand_id')
        ->join('models', 'support_tickets.ticket_model', '=', 'models.model_id')
        ->join('support_categories', 'support_tickets.ticket_category', '=', 'support_categories.category_id')
        ->join('technicians', 'support_tickets.ticket_tech', '=', 'technicians.tech_id')
        ->limit(15)->offset(0)->orderByDesc('ticket_create')->get();

        echo json_encode($tickets);
    }

    public function changeStatus(Request $request) {
        // return $request;
        $ticket_id = $request->ticket_id;
        $status   = Support_ticket::where('ticket_id', $ticket_id)->update([
            'ticket_status'   => $request->status
        ]);

        $record = Support_ticket::where('ticket_id', $ticket_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }


    public function getReplie($ticket_id){

        $replies = Support_replie::where('reply_ticket', $ticket_id)->orderBy('reply_create', 'DESC')->get();
        return view('content.supports.replies', compact('replies'));
    }

    public function replie(Request $request) {
        // return $request;
        $request->validate([
            'replie'      => 'required | string',
            'ticket_id'   => 'required | numeric'
        ]);

        Support_ticket::where('ticket_id', $request->ticket_id)->update(['ticket_status' => 2]);
        if(!$request->attachment){
            $status = Support_replie::create([
                'reply_context'  => $request->replie,
                'reply_ticket'   => $request->ticket_id,
                'reply_user'     => auth()->user()->id,
                'reply_create'   => Carbon::now()
            ]);

            $reply_id = $status->id;
            $record   = Support_replie::where('reply_id', $reply_id)->first();
        }
        else{
            $attachment = $request->file('attachment');
            $attachmentName = $attachment->getClientOriginalName();
            $location = 'Image/supports/';
            $attachment->move($location , $attachmentName);
            $attachmentPath = url($location, $attachmentName);
            $status = Support_attachment::create([
                'attach_file'       => $attachmentName,
                'attach_ticket'     => $request->ticket_id,
                'attach_time'       => Carbon::now()
            ]);

            $attach_id = $status->id;
            $record   = Support_attachment::where('attach_id', $attach_id)->first();
        }

        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }
}
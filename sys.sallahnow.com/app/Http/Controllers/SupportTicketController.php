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

    public function index()
    {
        return view('content.supports.tickets');
    }

    public function load(Request $request)
    {
        $params = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(Support_ticket::fetch(0, $params, $limit, $lastId));
    }

    public function changeStatus(Request $request)
    {
        $id = $request->ticket_id;
        $params  = ['ticket_status' => $request->status];

        $result = Support_ticket::submit($params, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Support_ticket::fetch($id) : [],
        ]);
    }


    public function getReplie($ticket_id){
        $param[] = ['reply_ticket', $ticket_id];
        $replies = Support_replie::fetch(0,$param);

        return view('content.supports.replies', compact('replies'));
    }

    public function replie(Request $request) {

        $request->validate([
            'replie'      => 'required | string',
            'ticket_id'   => 'required | numeric'
        ]);

        $paramRely =
        [
            'reply_context'  => $request->replie,
            'reply_ticket'   => $request->ticket_id,
            'reply_user'     => auth()->user()->id,
            'reply_create'   => Carbon::now()
        ];


        // where('ticket_id', $request->ticket_id)->update()
        Support_ticket::submit(['ticket_status' => 2], $request->ticket_id);
        if(!$request->attachment){
            $result = Support_replie::submit($paramRely);
        }
        else{
            $attachment = $request->file('attachment');
            $attachmentName = $attachment->getClientOriginalName();
            $location = 'Image/supports/';
            $attachment->move($location , $attachmentName);
            $attachmentPath = url($location, $attachmentName);
            $paramAttachment =
            [
                'attach_file'       => $attachmentName,
                'attach_ticket'     => $request->ticket_id,
                'attach_time'       => Carbon::now()
            ];

            $result = Support_attachment::submit($paramAttachment);
        }

        echo json_encode([
            'status' => boolval($result),
        ]);
    }
}
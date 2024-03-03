<?php

namespace App\Http\Controllers;

use App\Models\Chat_Room;
use App\Models\Chat_Room_Members;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatRoomController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index() {
        return view('content.chats.index');
    }

    public function getChatRoom($tech_id) {
        // Chat_Room_Members::where()->get();
        $chats = DB::table('chat_room_members')
                 ->join('chat_rooms', 'chat_room_members.member_room', '=', 'chat_rooms.room_id')
                 ->where('member_tech', $tech_id)->get();
        echo json_encode($chats);
    }


    public function submit(Request $request) {
        $request->validate([
            'room_type' => 'required|numeric'
        ]);
        $code = strtoupper($this->uniqidReal());
        $parma = [
            'room_code' => $code,
            'room_type' => $request->room_type,
            'room_name' => $request->room_name
        ];

        $room_id = $request->room_id;
        if(!$room_id){
            $status = Chat_Room::create($parma);

            $room_id = $status->room_id;
        }
        else {
            $status = Chat_Room::where('room_id', $room_id)->update($parma);
        }

        $record =  Chat_Room::where('room_id', $room_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function getTechnician($item) {
        $technician_name = Technician::where('tech_code', 'like', '%' . $item . '%')->get();
        echo json_encode($technician_name);
    }

    public function getMessage($room_id) {
        $chats = DB::table('chat_room_messages')
        ->join('chat_rooms', 'chat_room_messages.msg_room', '=', 'chat_rooms.room_id')
        ->join('technicians', 'chat_room_messages.msg_from', 'technicians.tech_id')
        ->where('chat_room_messages.msg_room', $room_id)->get();
        echo json_encode($chats);
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
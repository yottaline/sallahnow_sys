<?php

namespace App\Http\Controllers;

use App\Models\Chat_Room;
use App\Models\Chat_Room_Members;
use App\Models\Chat_Room_Message;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatRoomController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $technicians = Technician::fetch();
        return view('content.chats.index', compact('technicians'));
    }

    public function getChatRoom($tech_id)
    {
        $params[] = ['chat_room_members.member_tech', $tech_id];
        $chats = Chat_Room_Members::getteh($tech_id);
        if(count($chats)){
            echo json_encode($chats);
        }else{
            echo json_encode([
                'status' => false,
                'message' => 'not data'
            ]);
        }

    }


    public function submit(Request $request)
    {
        $request->validate([
            'room_type' => 'required|numeric'
        ]);
        $code = strtoupper($this->uniqidReal());
        $param = [
            'room_code' => $code,
            'room_type' => $request->room_type,
            'room_name' => $request->room_name
        ];
        $id = $request->room_id;


        $result =  Chat_Room::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Chat_Room::fetch($id) : [],
        ]);
    }

    public function getTechnician($item)
    {
        $param[] = ['tech_code', 'like', '%' . $item . '%'];
        $technician_name = Technician::fetch(0, $param);
        echo json_encode($technician_name);
    }

    public function getMessage($room_id)
    {
        echo json_encode(Chat_Room_Message::msg_room($room_id));
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

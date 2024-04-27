<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat_Room;
use App\Models\Chat_Room_Members;
use App\Models\Chat_Room_Message;
use App\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    use ResponseApi;

    public function __construct()
    {
        return $this->middleware(['auth:technician-api', 'check_device_token']);
    }

    public function chat($tech_id)
    {
        $params[] = ['member_tech', $tech_id];
        $chats = Chat_Room_Members::fetch(0, $params);

        return $this->returnData('chats', $chats);
    }

    public function createRoom(Request $request)
    {

        $request->validate([
            'room_type' => 'required|numeric'
        ]);

        $code = strtoupper($this->uniqidReal());
        $param =
        [
            'room_code' => $code,
            'room_type' => $request->room_type,
            'room_name' => $request->room_name
        ];
        $result = Chat_Room::submit($param, null);

        $room = $result ? Chat_Room::fetch($result) : [];

        return $this->returnData('room', $room);
    }

    public function addMember(Request $request)
    {

        $request->validate([
            'member_room' => 'required|numeric',
            'member_tech' => 'required|numeric',
        ]);
        $status = Chat_Room_Members::submit($request->member_room, $request->member_tech);

        $member = Chat_Room_Members::getChatMember($status->id);

        return $this->returnData('member', $member);

    }

    public function createMessage(Request $request)
    {

      $data = $request->validate([
            'msg_from'    => 'required |numeric',
            'msg_room'    => 'required |numeric',
            'msg_context' => 'required |string'
        ]);

        $data['msg_create'] = Carbon::now();
        $result = Chat_Room_Message::submit($data, null);

        $message = $result ? Chat_Room_Message::getFirstElementById($result) : [];
        return $this->returnData('message', $message);
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
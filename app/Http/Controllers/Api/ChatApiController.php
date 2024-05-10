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

    public function chat(Request $request)
    {
        $tech_id = $request->tech;
        $params[] = ['member_tech', $tech_id];
        $chats = Chat_Room_Members::fetch(0, $params);

        return $this->returnData('data', $chats);
    }

    public function createRoom(Request $request)
    {

        $request->validate([
            'type' => 'required|numeric',
            'name' => 'required'
        ]);

        $code = strtoupper($this->uniqidReal());
        $id = $request->id;
        $param =
        [
            'room_code' => $code,
            'room_type' => $request->type,
            'room_name' => $request->name
        ];

        $result = Chat_Room::submit($param, $id);

        $room = $result ? Chat_Room::fetch($result) : [];

        return $this->returnData('data', $room);
    }

    public function addMember(Request $request)
    {
        $request->validate([
            'room' => 'required|numeric',
            'tech' => 'required|numeric',
        ]);

        $param = [
            'member_room' => $request->room,
            'member_tech' => $request->tech,
            'member_add'  => Carbon::now()
        ];

        $result = Chat_Room_Members::submit($param, null);
        $member = Chat_Room_Members::getChatMember($result);

        return $this->returnData('data', $member);

    }

    public function createMessage(Request $request)
    {

      $request->validate([
            'tech'    => 'required |numeric',
            'room'    => 'required |numeric',
            'text'    => 'required |string'
        ]);

        $id = $request->id;
        $param = [
            'msg_room'    => $request->room,
            'msg_from'    => $request->tech,
            'msg_context' => $request->text,
            'msg_create'  => Carbon::now()
        ];

        $result = Chat_Room_Message::submit($param, $id);
        $message = $result ? Chat_Room_Message::getFirstElementById($result) : [];
        return $this->returnData('data', $message);
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
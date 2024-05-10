<?php
namespace App;

trait ResponseApi {

    // return error message
    public function returnError($message, $number){
        return response() -> json(
            [
                'status_bool' => false,
                'status'    => $number,
                'message'    => $message
            ]
        );
    }

    // return success message
    public function returnSuccess($message) {
        return response() -> json(
            [
                'status_bool'  => true,
                'status' => '100',
                'message'     => $message
            ]
            );
    }

    // return data and message
    public function returnData($key , $value , $message = ''){
        return response() -> json(
            [
                'status_bool' => true,
                'status'      => '100',
                'message'     => $message,
                $key          => $value
            ]
            );
    }


    public function returnValidator($input)
    {
       if($input == 'name') return 'E2001';
       elseif ($input == 'password') return 'E2002';
       elseif ($input == 'email') return 'E2003';
       else return '';
    }


    public function returnValidatorError($code , $validort)
    {
        return $this->returnError($code , $validort->errors()->first());
    }
}
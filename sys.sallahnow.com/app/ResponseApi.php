<?php
namespace App;

trait ResponseApi {

    // return error msg
    public function returnError($msg, $number){
        return response() -> json(
            [
                'status' => false,
                'status_number'    => $number,
                'msg'    => $msg
            ]
        );
    }

    // return success msg
    public function returnSuccess($msg) {
        return response() -> json(
            [
                'status'  => true,
                'status_number' => '100',
                'msg'     => $msg
            ]
            );
    }

    // return data and msg
    public function returnData($key , $value , $msg = ''){
        return response() -> json(
            [
                'status' => true,
                'status_number'   => '200',
                'msg'    => $msg,
                $key     => $value
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

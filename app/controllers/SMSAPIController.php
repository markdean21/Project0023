<?php

class SMSAPIController extends \BaseController {
    // SHORT CODE FROM CHIKKA API - 29290 62641
    // CLIENT ID - 76b4f21bfbaeec04b3a79c83860fde6fc37810dd427918c21ebd973becff97e8
    // SECRET KEY - a3e207f05220a9dae9821efe2b655444cbf5e6c366b3fc7077dbf433dd9bf39e

    public function receive()  {
        $request_id = Input::get('request_id');
        $message_type = Input::get('message_type');
        $mobile_number = Input::get('mobile_number');
        $shortcode = Input::get('shortcode');
        $message = Input::get('message');
        $timestamp = Input::get('timestamp');

        //DO app specific stuff --  save it, log it, process it etc.

        $reply = 'This is your reply';
        $this->sendReply($mobile_number, $reply, $request_id, 'FREE');
        return "Accepted";
    }

    public function notify() {
        //Delivery notification tells you if the message/reply you sent failed.
        $shortcode = Input::get("shortcode");
        $message_id = Input::get("message_id");
        $status = Input::get("status");
        $credits = Input::get("credits_cost");
        $timestamp = Input::get("timestamp");

        //Process DN
        return "Accepted";
//        return array(
//            'shortCode'     =>  $shortcode,
//            'message_id'    =>  $message_id,
//            'status'        =>  $status,
//            'credits'       =>  $credits,
//            'timestamp'     =>  $timestamp
//        );
    }

//    public function sendSms($mobileNum, $message){
//        $arr_post_body = array(
//            "message_type" => "SEND",
//            "mobile_number" => "639181234567",
//            "shortcode" => "2929062641",
//            "message_id" => Sms::max('id')+1,
//            "message" => urlencode($message),
//            "client_id" => "76b4f21bfbaeec04b3a79c83860fde6fc37810dd427918c21ebd973becff97e8",
//            "secret_key" => "a3e207f05220a9dae9821efe2b655444cbf5e6c366b3fc7077dbf433dd9bf39e"
//        );
//
//        $query_string = "";
//        foreach($arr_post_body as $key => $frow)
//        {
//            $query_string .= '&'.$key.'='.$frow;
//        }
//
//        $URL = "https://post.chikka.com/smsapi/request";
//
//        $curl_handler = curl_init();
//        curl_setopt($curl_handler, CURLOPT_URL, $URL);
//        curl_setopt($curl_handler, CURLOPT_POST, count($arr_post_body));
//        curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
//        curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
//        $response = curl_exec($curl_handler);
//        curl_close($curl_handler);
//
//        exit(0);
//    }
}

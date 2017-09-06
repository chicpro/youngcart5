<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/*
https://api.slack.com/methods/chat.postMessage

Token 생성 : https://api.slack.com/custom-integrations/legacy-tokens
*/

class SLACK
{
    private $token;
    private $channel;
    private $username;
    private $message;

    public function __construct($token, $username='Slack Bot') {
        $this->token    = $token;
        $this->username = $username;
    }

    public function setChannel($channel) {
        $this->channel = $channel;
    }

    public function setUsetName($username) {
        $this->username = $username;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function send() {
        $postData = array(
            'token'    => $this->token,
            'channel'  => $this->channel,
            'username' => $this->username,
            'text'     => $this->message
        );

        $ch = curl_init("https://slack.com/api/chat.postMessage");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
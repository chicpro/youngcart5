<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/**
 * Author : chicpro (http://ncube.net)
 *
 * https://ncube.net/13536
 * https://ncube.net/13541
 * https://core.telegram.org/bots
 * https://core.telegram.org/bots/api#sendmessage
**/

class TELEGRAM
{
    private $apiURL;
    private $chatID;
    private $token;
    private $text;
    private $parseMode;

    public function __construct($token) {
        $this->token = $token;
        $this->apiURL = 'https://api.telegram.org/bot';        
        $this->parseMode = 'Markdown';
    }

    public function setChatID($chatID) {
        $this->chatID = $chatID;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setParseMode($mode) {
        $this->parseMode = $mode;
    }

    public function sendMessage() {
        $url = $this->apiURL . $this->token . '/sendmessage?chat_id=' . $this->chatID . '&text=' . $this->text;
        if($this->parseMode && ($this->parseMode == 'HTML' || $this->parseMode == 'Markdown'))
            $url .= '&parse_mode=' . $this->parseMode;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
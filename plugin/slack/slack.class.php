<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/*
https://api.slack.com/incoming-webhooks
https://www.webpagefx.com/tools/emoji-cheat-sheet/
*/

class SLACK
{
    private $webHookUrl;
    private $channel;
    private $userName;
    private $message;
    private $iconEmoji;
    private $iconUrl;
    private $attachments;
    private $attachmentsText;
    private $attachmentsPreText;
    private $attachmentsColor;

    public function __construct($webHookUrl='', $userName='') {
        $this->webHookUrl  = $webHookUrl;
        $this->userName    = $userName;
        $this->iconEmoji   = '';
        $this->iconUrl     = '';
        $this->message     = '';
        $this->attachments = array();
    }

    public function setWebHookUrl($webHookUrl) {
        $this->webHookUrl = $webHookUrl;
    }

    public function setChannel($channel) {
        $this->channel = $channel;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    private function subString($str, $len=0, $suffix='…') {
        $_str = trim($str);

        if($len > 0) {
            $arrStr = preg_split("//u", $_str, -1, PREG_SPLIT_NO_EMPTY);
            $strLen = count($arrStr);

            if ($strLen >= $len) {
                $sliceStr = array_slice($arrStr, 0, $len);
                $str = join('', $sliceStr);

                $_str = $str . ($strLen > $len ? $suffix : '');
            } else {
                $_str = join('', $arrStr);
            }
        }

        return $_str;
    }

    public function setAttachmentsText($text, $len=0) {
        $this->attachmentsText = $this->subString($text, $len);
    }

    public function setAttachmentPreText($pretext) {
        $this->attachmentsPreText = $pretext;
    }

    public function setAttachmentsColor($color) {
        $this->attachmentsColor = $color;
    }

    private function setAttachments() {
        $this->attachments[] = array(
            'pretext'   => $this->attachmentsPreText,
            'text'      => $this->attachmentsText,
            'color'     => $this->attachmentsColor,
            'mrkdwn_in' => array('text', 'pretext')
        );
    }

    public function setIconEmoji($iconEmoji) {
        $iconEmoji = strip_tags(trim($iconEmoji));

        if($iconEmoji)
            $this->iconEmoji = $iconEmoji;
    }

    public function setIconUrl($iconUrl) {
        $iconUrl = strip_tags(trim($iconUrl));

        if($iconUrl)
            $this->iconUrl = $iconUrl;
    }

    public function send() {
        if($this->webHookUrl) {
            $this->setAttachments();

            $postData = array(
                'channel'     => $this->channel,
                'username'    => $this->userName,
                'icon_emoji'  => $this->iconEmoji,
                'icon_url'    => $this->iconUrl,
                'text'        => $this->message,
                'attachments' => $this->attachments,
                'mrkdwn'      => true,
                'link_names'  => 1
            );

            $ch = curl_init($this->webHookUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS,     'payload='.json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        } else {
            return 'WebHook URL Error';
        }
    }
}
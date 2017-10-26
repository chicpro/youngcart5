<?php
if (!defined('_GNUBOARD_')) exit;

/*
 ONESIGNAL WebPush API
 https://onesignal.com/
 https://documentation.onesignal.com/reference
*/

class ONESIGNAL {
    private $app_id;
    private $web_id;
    private $rest_api_key;

    private $api_url = 'https://onesignal.com/api/v1/notifications';
    
    private $url;
    private $fields;    
    private $headings;
    private $contents;        
    private $included_segments;    
    
    public function __construct($included_segments='All') {
        $app_id = '';
        $web_id = '';
        $rest_key = '';

        if(defined('G5_ONESIGNAL_APP_ID'))
            $app_id = trim(G5_ONESIGNAL_APP_ID);
        
        if(defined('G5_ONESIGNAL_REST_API_KEY'))
            $rest_key = trim(G5_ONESIGNAL_REST_API_KEY);
        
        if(defined('G5_ONESIGNAL_WEB_ID'))
            $web_id = trim(G5_ONESIGNAL_WEB_ID);
        
        if(!$app_id || !$rest_key || !$web_id)
            throw new Exception('ONESIGNAL APP ID, REST API KEY, WEB ID 를 설정해 주십시오.');
        
        $this->app_id = $app_id;
        $this->web_id = $web_id;
        $this->rest_api_key = $rest_key;
        
        $this->headings = array();
        $this->contents = array();
        $this->included_segments = array();

        if(!is_array($included_segments))
            $this->included_segments[] = $included_segments;
        else
            $this->included_segments = array_merge($this->included_segments, $included_segments);
    }

    public function setHeadings($headings) {
        if(!is_array($headings))
            $headings = array('en' => $headings);
        
        $this->headings = array_merge($this->headings, $headings);
    }

    public function makeContents($content) {
        $_wr_content = strip_tags(str_replace(array("\n\r", "\r\n", "\n", "\r", "\t"), ' ', $content));
        return preg_replace('#\s+#', ' ', $_wr_content);
    }

    public function setContents($contents) {
        if(!is_array($contents))
            $contents = array('en' => $contents);
        
        $this->contents = array_merge($this->contents, $contents);
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    private function setFields() {
        $this->fields = array(
            'app_id'            => $this->app_id,
            'safari_web_id'     => $this->web_id,
            'included_segments' => $this->included_segments,
            'headings'          => $this->headings,
            'contents'          => $this->contents,
            'url'               => $this->url
        );
    }

    public function sendMessage() {
        $this->setFields();

        print_r($this->fields);

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic ' . $this->rest_api_key));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->fields));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
    }
}
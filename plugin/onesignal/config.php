<?php
if (!defined('_GNUBOARD_')) exit;

/*
 ONESIGNAL WebPush API
 https://onesignal.com/
*/

define('G5_ONESIGNAL_USE', true);

if(!defined('G5_ONESIGNAL_USE') || G5_ONESIGNAL_USE !== true)
    return;

define('G5_ONESIGNAL_APP_ID',       '');
define('G5_ONESIGNAL_WEB_ID',       '');
define('G5_ONESIGNAL_REST_API_KEY', '');

if(!defined('G5_ONESIGNAL_APP_ID') || !defined('G5_ONESIGNAL_WEB_ID') || !defined('G5_ONESIGNAL_REST_API_KEY'))
    return;

// 경로설정
define('G5_ONESIGNAL_PATH', G5_PLUGIN_PATH.'/onesignal');

// 알림 메세지 글자수
define('G5_ONESIGNAL_LENGTH', 30);

// onesignal JS setup
if(!defined('G5_IS_ADMIN') || G5_IS_ADMIN !== true) {
    $config['cf_add_script'] .= PHP_EOL.'<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async="async"></script>
    <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
        appId: "'.G5_ONESIGNAL_APP_ID.'",
        autoRegister: false, /* Set to true to automatically prompt visitors */
        notifyButton: {
            enable: true /* Set to false to hide */
        }
    }]);
    </script>';
}
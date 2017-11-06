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
define('G5_ONESIGNAL_URL',  str_replace(G5_PATH, G5_URL, G5_ONESIGNAL_PATH));

// 알림 메세지 글자수
define('G5_ONESIGNAL_LENGTH', 30);

// onesignal JS setup
if(!defined('G5_IS_ADMIN') || G5_IS_ADMIN !== true) {
    $config['cf_add_script'] .= PHP_EOL.'<link rel="manifest" href="'.G5_ONESIGNAL_URL.'/manifest.json">
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
    <script>
    var OneSignal = window.OneSignal || [];
    
    OneSignal.push( function() {
        OneSignal.SERVICE_WORKER_UPDATER_PATH = "OneSignalSDKUpdaterWorker.js.php";
        OneSignal.SERVICE_WORKER_PATH = "OneSignalSDKWorker.js.php";
        OneSignal.SERVICE_WORKER_PARAM = { scope: \'/\' };

        OneSignal.setDefaultNotificationUrl("'.G5_URL.'");
        var oneSignal_options = {};
        window._oneSignalInitOptions = oneSignal_options;

        oneSignal_options[\'appId\'] = "'.G5_ONESIGNAL_APP_ID.'";
        oneSignal_options[\'autoRegister\'] = false;
        oneSignal_options[\'path\'] = "'.G5_ONESIGNAL_URL.'/";
        oneSignal_options[\'safari_web_id\'] = "'.G5_ONESIGNAL_WEB_ID.'";
        oneSignal_options[\'notifyButton\'] = { };
        oneSignal_options[\'notifyButton\'][\'enable\'] = true;

        OneSignal.init(window._oneSignalInitOptions);
    });
    </script>'.PHP_EOL;
}

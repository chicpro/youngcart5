<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(is_file(G5_PLUGIN_PATH.'/onesignal/config.php'))
    include_once(G5_PLUGIN_PATH.'/onesignal/config.php');
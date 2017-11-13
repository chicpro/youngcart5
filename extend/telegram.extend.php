<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/**
 * Author : chicpro (http://ncube.net)
 *
 * https://ncube.net/13536
 * https://ncube.net/13541
 * https://core.telegram.org/bots
**/

define('TELEGRAM_DIR',    'telegram');
define('TELEGRAM_CONFIG', 'config.php');

if(is_file(G5_PLUGIN_PATH.'/'.TELEGRAM_DIR.'/'.TELEGRAM_CONFIG))
    include_once(G5_PLUGIN_PATH.'/'.TELEGRAM_DIR.'/'.TELEGRAM_CONFIG);
else
    return;
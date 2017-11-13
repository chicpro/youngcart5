<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/**
 * Author : chicpro (http://ncube.net)
 *
 * https://ncube.net/13536
 * https://ncube.net/13541
 * https://core.telegram.org/bots
**/

// Telegram Bot Token
define('TELEGRAM_TOKEN', '');

// Telegram Plugin Path
define('G5_TELEGRAM_PATH', G5_PLUGIN_PATH.'/'.TELEGRAM_DIR);

// Telegram Chat ID가 기록된 member table
define('G5_TELEGRAM_CHAT_ID', 'mb_10');
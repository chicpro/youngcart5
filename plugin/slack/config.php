<?php
if (!defined('_GNUBOARD_')) exit;

/*
https://api.slack.com/incoming-webhooks
https://www.webpagefx.com/tools/emoji-cheat-sheet/
*/

define('G5_SLACK_USE', true);

if(!defined('G5_SLACK_USE') || G5_SLACK_USE !== true)
    return;

// 경로설정
define('G5_SLACK_PATH', G5_PLUGIN_PATH.'/'.G5_SLACK_DIR);

// Slack 설정
define('G5_SLACK_WEBHOOK_URL', '');
define('G5_SLACK_CHANNEL',     '#general');
define('G5_SLACK_ICON_URL',    'https://a.slack-edge.com/41b0a/img/plugins/app/service_36.png');
define('G5_SLACK_EMOJI',       ':loudspeaker:');
define('G5_SLACK_BAR_COLOR',   '#36a64f');
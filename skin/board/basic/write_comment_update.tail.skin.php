<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == 'c') {
    if(defined('G5_SLACK_USE') && G5_SLACK_USE === true && is_file(G5_SLACK_PATH.'/slack.class.php'))
        include_once(G5_SLACK_PATH.'/slack.class.php');
    else
        return;

    $info = array();

    $info[] = '이름 : ' . strip_tags($wr_name);
    
    // 게시글 링크
    $info[] = '<'.urlencode(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr['wr_parent'].'#c_'.$comment_id).'|댓글 보기>';

    // wr_content 가공
    $_wr_content = preg_replace('#<br\s*/?>#i', "\n", $wr_content);

    // 메일 발송을 사용하는 경우 $wr_content 변경됨
    if($config['cf_email_use'] && $board['bo_use_email']) {
        $_temp = explode("댓글\n", $_wr_content);
        $_wr_content = array_pop($_temp);
    }

    $info[] = strip_tags($_wr_content);

    $_text    = implode("\n", $info);
    $_pretext = '';
    
    if($wr['ca_name'])
        $_pretext .= strip_tags($wr['ca_name']) . ' | ';
    
    $_pretext .= strip_tags($wr['wr_subject']);

    $slack = new SLACK();

    $slack->setWebHookUrl(G5_SLACK_WEBHOOK_URL);
    $slack->setChannel(G5_SLACK_CHANNEL);

    $slack->setUserName('[댓글등록알림]');
    //$slack->setIconEmoji(G5_SLACK_EMOJI);
    $slack->setIconUrl(G5_SLACK_ICON_URL);
    //$slack->setMessage('Slack 메세지 내용');
    $slack->setAttachmentsText($_text);
    $slack->setAttachmentPreText($_pretext);
    $slack->setAttachmentsColor(G5_SLACK_BAR_COLOR);

    $result = $slack->send();

    //print_r($result); exit;
}
?>
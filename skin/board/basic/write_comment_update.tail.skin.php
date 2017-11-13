<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == 'c') {
    if(!defined('G5_TELEGRAM_PATH'))
        return;
    
    if($wr_content && $wr['mb_id']) {
        $_member = get_member($wr['mb_id'], G5_TELEGRAM_CHAT_ID);

        if(!$_member[G5_TELEGRAM_CHAT_ID])
            return;

        include_once(G5_TELEGRAM_PATH.'/telegram.class.php');

        $telegram = new TELEGRAM(TELEGRAM_TOKEN);        
        
        $_wr_content = strip_tags($board['bo_subject'].' '.strip_tags($wr['wr_subject']).'에 댓글이 등록됐습니다. ').'[댓글 보기]('.urlencode(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id.'#c_'.$comment_id).')';

        $telegram->setChatID($_member[G5_TELEGRAM_CHAT_ID]);
        $telegram->setText($_wr_content);

        $result = $telegram->sendMessage();
        //print_r($result);
    }
}
?>
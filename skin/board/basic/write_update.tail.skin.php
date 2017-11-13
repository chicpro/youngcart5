<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == '') {
    if(!defined('G5_TELEGRAM_PATH'))
        return;

    // 관리자 Chat ID
    $_member = get_admin('super', G5_TELEGRAM_CHAT_ID);
    
    if($_member[G5_TELEGRAM_CHAT_ID] && $wr_content) {
        include_once(G5_TELEGRAM_PATH.'/telegram.class.php');

        $telegram = new TELEGRAM(TELEGRAM_TOKEN);
    
        $_wr_content = strip_tags($board['bo_subject'].' 게시판에 게시글이 등록됐습니다. ').'[게시글 보기]('.urlencode(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id).')';

        $telegram->setChatID($_member[G5_TELEGRAM_CHAT_ID]);
        $telegram->setText($_wr_content);

        $result = $telegram->sendMessage();
        //print_r($result); exit;
    }    
}
?>
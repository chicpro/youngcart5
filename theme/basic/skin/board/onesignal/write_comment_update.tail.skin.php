<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == 'c') {
    if(defined('G5_ONESIGNAL_USE') && G5_ONESIGNAL_USE === true && is_file(G5_ONESIGNAL_PATH.'/onesignal.lib.php'))
        include_once(G5_ONESIGNAL_PATH.'/onesignal.lib.php');

    $onesignal = new ONESIGNAL();

    $_wr_content = $onesignal->makeContents($wr_content);
    $_wr_content = cut_str($_wr_content, G5_ONESIGNAL_LENGTH);

    $onesignal->setHeadings(strip_tags($wr['wr_subject']));
    $onesignal->setContents($_wr_content);
    $onesignal->setUrl(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr['wr_parent'].'#c_'.$comment_id);

    $result = $onesignal->sendMessage();

    //print_r($result); exit;
}
?>
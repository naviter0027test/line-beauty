<?php
//打開緩衝區
ob_start();

if (isset($_POST['sid'])) {
	session_id(base64_decode(strrev($_POST['sid'])));
	session_start();
} else {
	session_start();
}
//LOGIN 基本設定
$SK_LOGIN_VALID = "SK_LOGIN_VALID";
$SK_LOGIN_ACCOUNT = "SK_LOGIN_ACCOUNT";
$SK_LOGIN_RANK = "SK_LOGIN_RANK";
$SK_MEMLOGIN_VALID = "SK_MEMLOGIN_VALID";
@ini_set( 'upload_max_size' , '50M' );
@set_time_limit(5 * 60);

error_reporting(0);
?>
<?php
require_once 'panelldf0!fl/library/class.db.php';
require_once 'panelldf0!fl/library/func.php';
$db = new DB();
//現在時間
$today=date("Y-m-d H:i:s");
ini_set('date.timezone', 'Asia/Taipei');
//WEBURL
#define('WEB_URL', 'http://line55888.com/');
define('WEB_URL', 'http://linebeauty.axcell28.idv.tw/');

$url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//目前網站網址&登錄碼&追蹤碼管理
$colname_mailbox = "1";
$row_mailbox= $db->getRows('mailbox',array('where'=>array('idx'=>$colname_mailbox ),'return_type'=>'single'));
//關鍵字管理
if($_SERVER['REQUEST_URI']!="/"){$page=$_SERVER['REQUEST_URI'];}else{$page="/index";}
$row_web_title= $db->getRows('web_title',array('where'=>array('web_page'=>$page),'return_type'=>'single'));

define('WEB_TITLE', 'Beauty│');
define('WEB_TITLE2', 'Beauty');
$show=1;
$catano="-2";
$vedio_path="/vedio/";

?>

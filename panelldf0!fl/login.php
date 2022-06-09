<?php 
include "init.include.php";
$editFormAction = $_SERVER['PHP_SELF'];

?>

<?php
//登出
unset($_SESSION[$SK_LOGIN_VALID]);
unset($_SESSION[$SK_LOGIN_ACCOUNT]);
unset($_SESSION[$SK_LOGIN_RANK]);

//============== 會員登入 ====================//
//檢查驗證碼
include_once '../_src/securimage/securimage.php';
$securimage = new Securimage();
//登入
if ((isset($_POST["login"])) && ($_POST["login"] == "yes")) {
if ($securimage->check($_POST['captcha_code']) != false) {
	//檢查帳號密號
	$username=trim($_POST["username"]);
	$password=trim(md5($_POST["password"]));
	$db = new DB();
    $row_admin = $db->getRows('admin',array('where'=>array('username'=>$username,'password'=>$password),'return_type'=>'single'));

		if (!empty($row_admin)){
			$_SESSION[$SK_LOGIN_VALID] = md5(session_id() . time() . $_SERVER['HTTP_USER_AGENT']);
			$_SESSION[$SK_LOGIN_ACCOUNT] = $row_admin['name'];
			$_SESSION[$SK_LOGIN_RANK] = $row_admin['rank'];
			
			  $url="../index-backend.php";
		       header(sprintf("Location: %s", $url));	
			   exit();

	
			}else if (!$row_admin){
			  echo "<script type='text/javascript'>";
			  echo "alert('帳號或密碼錯誤!');";
			  echo "window.history.go(-1);";
			  echo "</script>";
	
			}
	}else{
	  echo "<script type='text/javascript'>";
	  echo "alert('驗證碼錯誤!');";
	  echo "window.history.go(-1);";
	  echo "</script>";
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo WEB_TITLE ;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<?php include "_template/htmlhead.php"; ?>
<link href="css/page.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!--contetn-->
<div id="loginBox">
  <div id="loginLogo"><?php echo WEB_TITLE ;?></div>
<form id="form1" name="form1" method="post" action="">
<div class="on-focus">
			<input name="username" type="text"  class="minput" id="username" placeholder="請輸入帳號" />
<div class="tool-tip  slideIn">請輸入帳號</div>
</div>
<div class="on-focus">
			<input name="password" type="password"  class="minput" id="password" placeholder="請輸入密碼"/>
<div class="tool-tip  slideIn">請輸入密碼</div>
</div>
<div class="on-focus">
			<input name="captcha_code" type="text"  class="minput" id="captcha_code" placeholder="請輸入驗證碼"/>
<div class="tool-tip  slideIn">請輸入驗證碼</div>
</div>
<div class="clearfix">
  <div id="icon_reset" onclick="document.getElementById('captcha').src = '../_src/securimage/securimage_show.php?' + Math.random(); return false"></div>
  <div class="left"><img id="captcha" src="../_src/securimage/securimage_show.php" alt="CAPTCHA Image" /></div>
</div>
<div class="clearfix center">
<input name="" type="submit" value="登入" class="icon_add"/>
<input name="login" type="hidden" id="login" value="yes" />
</div>
</form>
</div>
<!--navi & contetn end-->

</body>
</html>


<!--NAVI-->
<div class="wrapper_head">
  <div class="item">
    <div class="boxnav">
      <ul>
	  <?php if(!empty($_SESSION[$SK_LOGIN_VALID])){?>
        <a href="index_backend.php"><li class="tickpost">貼文</li></a>
        <a href="marquee.php"><li class="tickmar">跑馬燈</li></a>
        <a href="post_cata.php"><li class="tickcata" >類別</li></a>
        <a href="acc_account.php"><li class="tickacc" >帳號</li></a>
        <li class="manager"></li>
        <dl class="boxsubnav">
           <a href="acc_account.php"> <dt><span>帳號設定立</span></dt></a>
           <a href="logout.php"><dt class="last"><span>登出</span></dt></a>
        </dl>
		<?php }?>
      </ul>
    </div>
  </div>
</div>
<!--NAVI END--> 

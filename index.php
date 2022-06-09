<?php 
include "_fphp/allpage.php";
$TB_cata="dbnews_cata";
$TB_news="dbnews";
//================================================================cata
$row_defcata = $db->getRows($TB_cata,array('order_by'=>'big_id ASC','limit'=>1,'return_type'=>'single'));
if (isset($_GET['cata']) &&($_GET['cata']!="") ) {
	  $cata = $_GET['cata'];
	}else{
	 $cata=$row_defcata['big_id'];
}
$row_nowcata = $db->getRows($TB_cata,array('where'=>array('big_id'=>$cata),'return_type'=>'single'));
$row_catas = $db->getRows($TB_cata,array('order_by'=>'big_id ASC'));


//================================================================LIST
$limit = !empty($_GET['limit'])?$_GET['limit']:5;
$page=!empty($_GET['page'])?$_GET['page']:0;
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$limit):0;

$row_news = $db->getRows($TB_news,array('where'=>array('big_id'=>$cata),'order_by'=>'idx DESC','start'=>$offset,'limit'=>$limit));
////count
$sql_count =$db->getRows($TB_news,array('where'=>array('big_id'=>$cata),'return_type'=>'count')
				);
//================================================================跑馬燈
$id=1;
$row_marquee = $db->getRows('dbmarquee',array('where'=>array('idx'=>$id),'return_type'=>'single'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
<?php include "_template/pagekeyword.php"; ?>
<link href="css/page.css" rel="stylesheet" type="text/css" />
<?php include "_template/htmlhead.php"; ?>
<!--SLIDE-->
<script type="text/javascript" src="_src/html5lightbox/html5lightbox.js"></script>

</head>

<body>
<?php if(!empty($_SESSION[$SK_LOGIN_VALID]) or !empty($_SESSION[$SK_MEMLOGIN_VALID])){?>
<?php }else{?>
<div class="overlay">
  <div class="box">
  未滿18歲請勿進入! 
  <div class="btn">
    <div>了解,已滿18歲</div> 
 </div>  
  </div>
  
</div>
<?php }?>
<!--HEAD-->
<?php if(!empty($_SESSION[$SK_LOGIN_VALID])){?>
<?php include "_template/naviarea.php"; ?>
<?php }?>
<!--HEAD END--> 
<!--CONTENT-->
<div class="wrapper_maincontent">

  <!--CATA-->
  <div class="wrapper_cata">
   <div class="logo"></div>
   <!--MARQUEE-->
<div class="clearfix"><div class="marquee" data-pauseOnHover="true">
       <?php if($row_marquee['new_title1']!=""){
		   if($row_marquee['new_link1']!=""){
		    $url1=explode("/",$row_marquee['new_link1']);?>
            <a href="<?php echo $row_marquee['new_link1'];?>" target="<?php if($url1[2]!=$_SERVER['HTTP_HOST']){echo "_blank";};?>">
		   <span><?php echo $row_marquee['new_title1'];?></span>
           </a>
          <?php }else{?>
            <span><?php echo $row_marquee['new_title1'];?></span>
          <?php  }?>
	   <?php }?>
       <?php if($row_marquee['new_title2']!=""){
		   if($row_marquee['new_link2']!=""){
		    $url2=explode("/",$row_marquee['new_link2']);?>
            <a href="<?php echo $row_marquee['new_link2'];?>" target="<?php if($url2[2]!=$_SERVER['HTTP_HOST']){echo "_blank";};?>">
		   <span><?php echo $row_marquee['new_title2'];?></span>
           </a>
          <?php }else{?>
            <span><?php echo $row_marquee['new_title2'];?></span>
          <?php  }?>
	   <?php }?>
       <?php if($row_marquee['new_title3']!=""){
		   if($row_marquee['new_link3']!=""){
		    $url3=explode("/",$row_marquee['new_link3']);?>
            <a href="<?php echo $row_marquee['new_link3'];?>" target="<?php if($url3[2]!=$_SERVER['HTTP_HOST']){echo "_blank";};?>">
		   <span><?php echo $row_marquee['new_title3'];?></span>
           </a>
          <?php }else{?>
            <span><?php echo $row_marquee['new_title3'];?></span>
          <?php  }?>
	   <?php }?>
       <?php if($row_marquee['new_title4']!=""){
		   if($row_marquee['new_link4']!=""){
		    $url4=explode("/",$row_marquee['new_link4']);?>
            <a href="<?php echo $row_marquee['new_link4'];?>" target="<?php if($url4[2]!=$_SERVER['HTTP_HOST']){echo "_blank";};?>">
		   <span><?php echo $row_marquee['new_title4'];?></span>
           </a>
          <?php }else{?>
            <span><?php echo $row_marquee['new_title4'];?></span>
          <?php  }?>
	   <?php }?>
       <?php if($row_marquee['new_title5']!=""){
		   if($row_marquee['new_link5']!=""){
		    $url5=explode("/",$row_marquee['new_link5']);?>
            <a href="<?php echo $row_marquee['new_link5'];?>" target="<?php if($url5[2]!=$_SERVER['HTTP_HOST']){echo "_blank";};?>">
		   <span><?php echo $row_marquee['new_title5'];?></span>
           </a>
          <?php }else{?>
            <span><?php echo $row_marquee['new_title5'];?></span>
          <?php  }?>
	   <?php }?>
		
      </div></div>
<!--MARQUEE-->
  <?php if(!empty($row_catas)){?>
  <ul>
	  <?php foreach($row_catas as $row_cata){?>
        <a href="<?php echo "index.php?cata=".$row_cata['big_id']?>"><li <?php if($row_cata['big_id']==$cata){ echo "class='now'";}?>><?php echo $row_cata['big_name'];?></li></a>
       <?php }?> 
  </ul>
   <?php }?>
    <div class="newmsg"><span>↑有新訊息....</span></div>
  </div>
<!--CATAs-->

<?php if(!empty($_SESSION[$SK_LOGIN_VALID])){?>
    <!--EDIT-->
    <div id="addnews">
    <div class="wrapper_cont ediit" data-id="<?php echo $cata;?>">
        <div class="box-newedit">
    <div class="pic_edit"></div> 
    <div class="w_edit">有什麼新鮮事嗎?</div>
    </div>
    </div>
    </div>
  <!--EDIT-->
<?php }?>
<input name="row" type="hidden" id="row" value="0">
<input type="hidden" id="all" value="<?php echo $sql_count; ?>">
<input name="cata" type="hidden" id="cata" value="<?php echo $cata;?>">
<div id="list">
<?php if(!empty($row_news)){?>
<?php foreach($row_news as $row_new){
	$row_curcata = $db->getRows($TB_cata,array('where'=>array('big_id'=>$row_new['big_id']),'return_type'=>'single'));
	$row_imgs = $db->getRows('files',array('where'=>array('idx'=>$row_new['idx']),'limit'=>4));
	$row_imgscount = $db->getRows('files',array('where'=>array('idx'=>$row_new['idx']),'return_type'=>'count'));
	$row_imgscount= (int)$row_imgscount-4;
	$row_vedio = $db->getRows('dbvedio',array('where'=>array('idx'=>$row_new['idx']),'return_type'=>'single'));
	$row_vediocount = $db->getRows('dbvedio',array('where'=>array('idx'=>$row_new['idx']),'return_type'=>'count'));
	$row_vediocount= (int)$row_vediocount-1;
	
?>
  <div class="wrapper_cont post" id="<?php echo $row_new['idx'];?>">
    <div class="row">
      <div class="boxtitle">
        <div class="title">
          <div class="area"><span><?php echo $row_curcata['big_name'];?></span></div>
          <div class="bt"><?php echo $row_new['new_title'];?></div>
        </div>
        <?php if(!empty($_SESSION[$SK_LOGIN_VALID])){?>
        <div class="edit"> </div>
        <dl class="boxsubnav post">
          <dt class="delthis" data-id="<?php echo $row_new['idx'];?>"><span>刪除</span></dt>
          <dt class="editthis" data-id="<?php echo $row_new['idx'];?>"><span>編輯</span></dt>
        </dl>
       <?php }?> 
      </div>
      <?php if(!empty($row_imgs) or !empty($row_vedio)){?>
          <div class="box_show">
              <ul class="photos">
                <?php foreach ($row_imgs as $row_img){$i=0;$i++;?>
                  <li>
                    <?php if($row_imgscount>0){?>
                   <a href="<?php echo "photos.php?cata=".$row_new['big_id']."&id=".$row_new['idx'];?>"  class="html5lightbox" data-width="1000" data-height="800" ><div class="viewmore">
                   <?php echo "+還有".$row_imgscount."張照片";?>
                    </div> </a><?php }?>
                    <a href="<?php echo "beautyimg/php/files/".$row_img['name'];?>" class="html5lightbox" data-group="<?php echo 'set'.$row_new['idx'];?>"><img src="<?php echo "beautyimg/php/files/".$row_img['name'];?>"></a>
                  </li>
                 <?php }?> 
                 <?php if(!empty($row_vedio)){?>
                   <li class="viedo">
                   <a href="<?php echo "vedio/".$row_vedio['file_src'];?>" class="html5lightbox" data-group="<?php echo 'set'.$row_new['idx'];?>">
                    <div class="viewvedio">
                  		  
                    </div>
                    </a>
                    </a>
                     <?php if($row_vediocount>0){?>
                      <a href="<?php echo "photos.php?cata=".$row_new['big_id']."&id=".$row_new['idx'];?>"  class="html5lightbox" data-width="1000" data-height="800" >
                    <div class="viewmore"> <?php echo "+還有".$row_vediocount."影片";?></div>
                    </a>
                     <?php }?>		
                  <video><source src="<?php echo "vedio/".$row_vedio['file_src'];?>#t=0.1" type="video/mp4"></video>
                    </li>
                   <?php }?>
                 </ul>
          </div>
      <?php }?>
      <div class="box_showword"><?php echo $row_new['new_message'];?></div>
      <div class="showmore"><span>...顯示更多</span></div>
    </div>
    <div class="show-more"></div>

  </div>
<?php }?>
<?php }else{?>  
<div class="wrapper_cont">
資料準備中...
</div>
<?php }?>  
</div>
<!-- </div>-->
</div>
<!--CONTENT END-->  
<script type="text/javascript">
	$(document).ready(function() {
		$('.tickpost').addClass('active');
	});
</script>   
<script type="text/javascript" src="js/postlist.js"></script>
<!--Marquee-->
<script src="_src/marquee/jquery.marquee.min.js"></script>
<script type="text/javascript">
$('.marquee').marquee({
    //speed in milliseconds of the marquee
    duration: 10000,
    //gap in pixels between the tickers
    gap: 100,
    //time in milliseconds before the marquee will start animating
    delayBeforeStart: 0,
    //'left' or 'right'
    direction: 'left',
    //true or false - should the marquee be duplicated to show an effect of continues flow
    duplicated: true
});
</script>
<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
			call: "0903183216", // Call phone number
            line: "//line.me/ti/p/_-fXylgyTq", // Line QR code URL
            telegram: "lovesex88888", // Telegram bot username
            call_to_action: "", // Call to action
            button_color: "#FF318E", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "line,telegram", // Order of buttons
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
</body>
</html>

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
<?php include "_template/pagekeyword_2.php"; ?>
    <link href="css/index_head.css" rel="stylesheet" type="text/css" />
    <link href="css/index-next.css" rel="stylesheet" type="text/css" />
<?php include "_template/htmlhead.php"; ?>

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

    <div class="wrapper_head">
        <img src="img/LOGO-001-white.png" class="logo1"></img> <!--label class="logo2">阿鬼</label-->
    </div>
    <div class="wrapper_head2">
<?php if(!empty($row_catas)){?>
    <?php foreach($row_catas as $i => $row_cata){?>
    <a href="<?php echo "index-next.php?cata=".$row_cata['big_id']?>" class="<?php echo $i % 2 == 0 ? 'head_green' : 'head_red'; ?>"><?php echo $row_cata['big_name'];?></a>
    <?php }?> 
<?php }?> 
<!--
        <a href="#" class="head_red">雙北外送</a>
        <a href="#" class="head_green">新竹外送</a>
        <a href="#" class="head_red">台中外送</a>
        <a href="#" class="head_green">宜蘭台東花蓮外送</a>
-->
    </div>

    <div class="marquee_x">
    <div>
        <div class="marquee" data-pauseOnHover="true">

    <?php for($new_i = 1; $new_i <= 5; ++$new_i) { ?>
    <?php if($row_marquee['new_title'. $new_i]!=""){
            if($row_marquee['new_link'. $new_i]!=""){
                $url1=explode("/",$row_marquee['new_link'. $new_i]);?>
            <a href="<?php echo $row_marquee['new_link'. $new_i];?>" target="<?php if($url1[2]!=$_SERVER['HTTP_HOST']){echo "_blank";};?>">
                <span><?php echo $row_marquee['new_title'. $new_i];?></span>
            </a>
    <?php }else{?>
            <span><?php echo $row_marquee['new_title'. $new_i];?></span>
    <?php  }?>
    <?php }?>
    <?php }?>

        </div>
    </div>
    </div>

    <div class="wrapper_maincontent">
        <div class="wrapper_content">

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
            <div class="box_show2 box_show" idx="<?php echo $row_new['idx']; ?>" row_imgscount="<?php echo count($row_imgs); ?>">
                <ul>
                <?php if(trim($row_imgs[0]['name']) != '') { ?>
                <li>
                    <a href="<?php echo "beautyimg/php/files/".$row_imgs[0]['name'];?>" class="html5lightbox" data-group="<?php echo 'set'.$row_new['idx'];?>">
                        <img class="show_img" src="<?php echo "beautyimg/php/files/".$row_imgs[0]['name'];?>" />
                    </a>
                </li>
                <?php for($i = 1;$i < count($row_imgs);++$i) { ?>
                <li>
                    <a href="<?php echo "beautyimg/php/files/".$row_imgs[$i]['name'];?>" class="html5lightbox" data-group="<?php echo 'set'.$row_new['idx'];?>" img_id="<?php echo $row_imgs[$i]['id']; ?>"></a>
                </li>
                <?php } ?>
                <?php if(!empty($row_vedio)) { ?>
                <li class="viedo">
                    <a href="vedio/<?php echo $row_vedio['file_src']; ?>" class="html5lightbox" data-group="<?php echo 'set'.$row_new['idx'];?>">
                    </a>
                </li>
                <?php } ?>
                <?php } else if(!empty($row_vedio)) { ?>
                <li class="viedo video_li">
                    <a href="vedio/<?php echo $row_vedio['file_src']; ?>" class="html5lightbox" data-group="<?php echo 'set'.$row_new['idx'];?>">
                        <img src="img/icon_vedio.png" class="video_play" />
                        <canvas class="viewvedio"></canvas>
                      <video><source src="<?php echo "vedio/".$row_vedio['file_src'];?>#t=0.1" type="video/mp4"></video>
                    </a>
                </li>
                <?php } ?>
                </ul>
                <div class="info_1">
                    <label class="info_1_1">
<?php 
        foreach($row_catas as $row_c)
            if($row_c['big_id'] == $row_nowcata['big_id']) {
                echo $row_c['big_name'];
                break;
            }
?>
                    </label>
                    <span class="info_span info_span_date"><img src="img/microphone-alt.png" /> <?php echo substr($row_new['created'], 0, 10); ?> </span>
                </div>
                <div class="info_2 box_showword">
<?php echo $row_new['new_message']; ?>
                </div>
                <div class="showmore"><span>...顯示更多</span></div>
            </div>

<?php }?>
<?php }else{?>  
<div class="wrapper_cont">
資料準備中...
</div>
<?php }?>  
<!--
            <div class="box_show2">
                <img src="http://fakeimg.pl/400x250/?text=img" />
                <div class="info_1">
                    <label class="info_1_1">雙北外送</label>
                    <span class="info_span info_span_date"><img src="img/microphone-alt.png" /> 2022/05/17</span>
                </div>
                <div class="info_2">
                    桃園+中壢外送報班-追加
                </div>
            </div>

            <div class="box_show2">
                <img src="http://fakeimg.pl/400x250/?text=img" />
                <div class="info_1">
                    <label class="info_1_2">中文字幕</label>
                    <label class="info_1_1">老師解說</label>
                    <span class="info_span info_span_date"><img src="img/microphone-alt.png" /> 2022/05/17</span>
                    <span class="info_span info_span_see"><img src="img/Vector.png" /> 3341次</span>
                    <a href="#" class="choice_love"><img src="img/Vector-love.png" /></a>
                </div>
                <div class="info_2">
                    報班網站: <a href="#">http://www.line88888.us</a>
                    <div class="info_2_desc">
最大的必須我覺得，冷之後就太好看，影片一堆回了你發現有中外面⋯還真氣死坑掉了每次都真的是，不會這設計。謝謝拜託大概人說是要很可愛，
                    </div>
                </div>
            </div>
-->

            <div class="page_show">
            <?php if($page == 0) $page = 1; ?>
            <?php if($page > 1) { ?>
                <a href="#" class="left-arrow">&lt;</a>
            <?php } ?>
                <div class="page_num">
                <?php for($page_i = 1;$page_i <= ceil($sql_count / $limit);++$page_i) { ?>
                <?php if($page_i == $page) { ?>
                    <label><?php echo $page_i; ?></label>
                <?php } else { ?>
                    <a href="index-next.php?page=<?php echo $page_i; ?>"><?php echo $page_i; ?></a>
                <?php } ?>
                <?php } ?>
<!--
                    <a href="#">1</a><a href="#">2</a><label>3</label><a href="#">4</a><a href="#">5</a>
-->
                </div>
            <?php if($page < ceil($sql_count / $limit)) { ?>
                <a href="#" class="right-arrow">&gt;</a>
            <?php } ?>
            </div>
            <br />

        </div>
    </div>
</body>
<script src="_src/marquee/jquery.marquee.min.js"></script>
<script src="js/plugins.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
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

        setTimeout(function() {
            for(var i = 0;i < $('.video_li').length;++i) {
                canvas_show(i);
            }
        }, 1500);
    });

    function canvas_show(i) {
        var video = document.getElementsByTagName('video')[i];
        var canvas = document.getElementsByTagName('canvas')[i];
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    }

    var videos = document.getElementsByTagName('video');
    for (var i = videos.length - 1; i >= 0; i--) {
        (function(){
            var p = i;
            videos[p].addEventListener('play',function(){
                pauseAll(p);
            })
        })()
    }
    function pauseAll(index){
        for (var j = videos.length - 1; j >= 0; j--) {
            if (j!=index) videos[j].pause();
        }
    };
</script>
</html>

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
    <title>阿鬼外送服務</title>
    <link href="css/index-next.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="wrapper_head">
        <img src="img/LOGO.png" class="logo1"></img> <label class="logo2">阿鬼</label>
    </div>
    <div class="wrapper_head2">
        <a href="#" class="head_green">桃園外送</a>
        <a href="#" class="head_red">雙北外送</a>
        <a href="#" class="head_green">新竹外送</a>
        <a href="#" class="head_red">台中外送</a>
        <a href="#" class="head_green">宜蘭台東花蓮外送</a>
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
                    <label class="info_1_1">雙北外送</label>
                    <span class="info_span info_span_date"><img src="img/microphone-alt.png" /> 2022/05/17</span>
                    <a href="#" class="choice_love"><img src="img/Vector-love.png" /></a>
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
                </div>
                <div class="info_2">
                    報班網站: <a href="#">http://www.line88888.us</a>
                    <div class="info_2_desc">
最大的必須我覺得，冷之後就太好看，影片一堆回了你發現有中外面⋯還真氣死坑掉了每次都真的是，不會這設計。謝謝拜託大概人說是要很可愛，
                    </div>
                </div>
            </div>

            <div class="page_show">
            </div>

        </div>
    </div>
</body>
<script src="js/jquery.min.js"></script>
<script src="_src/marquee/jquery.marquee.min.js"></script>
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
    });
</script>
</html>

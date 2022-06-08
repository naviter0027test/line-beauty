<?php 
include "_fphp/allpage.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >

    <title>阿鬼影片部落格 外送茶|定點樓鳳|外約</title>
    <meta name="title" content="阿鬼影片部落格 外送茶|定點樓鳳|外約">
    <meta name="description" content="阿鬼影片部落格 外送茶|定點樓鳳|外約">
    <meta property="og:description" content="阿鬼影片部落格 外送茶|定點樓鳳|外約" />
    <meta property="og:title" content="阿鬼影片部落格 外送茶|定點樓鳳|外約"/>
    <link href="css/index_head.css" rel="stylesheet" type="text/css" />
    <link href="css/index_detail.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="wrapper_head">
        <button class="head_left"><img src="img/list-head-left.png" /></button>
        <img src="img/LOGO-001-white.png" class="logo1"></img> <!--label class="logo2">阿鬼</label-->
        <a href="index-next.php" class="head_right">回上一頁</a>
    </div>
    <div class="wrapper_maincontent">
        <div class="box_left">
            <a href="index-next.php?cate=29">雙北外送</a>
            <a href="index-next.php?cate=15">桃園外送</a>
            <a href="index-next.php?cate=30">新竹外送</a>
            <a href="index-next.php?cate=31">台中外送</a>
            <a href="index-next.php?cate=33">彰雲外送</a>
            <a href="index-next.php?cate=34">台南外送</a>
        </div>
        <div class="box_show3">
            <span class="video_play"><img src="img/play.png"/><!--▶--></span>
            <span class="video_pause"><img src="img/pause.png"/></span>
            <video class="video_box">
                <source src="/vedio/202204202153136413.mp4#t=0.1" type="video/mp4">
                <!--source src="/vedio/202112201811213893.mp4#t=0.1" type="video/mp4"-->
            </video>
        </div>
        <div class="box_detail">
            <div class="box_progress">
                <span class="has_show has_text">05:33</span>
                <div class="progress_out">
                    <div class="progress_in"></div>
                </div>
                <span class="total_show has_text">11:88</span>
            </div>
            <div class="detail_show">
                <div class="info_1">
                    <label class="info_1_1">
                        雙北外送
                    </label>
                    <span class="info_span info_span_date"><img src="img/microphone-alt.png" /> 2022-06-02 </span>
                </div>
                <div class="info_2 box_showword">
有沒有只要是先不：的而不像人的覺得
<br /><br />以再的部分下去天沒標的是很當⋯自己的的內要去日本花，留本來是⋯更了小我可以小猜所以堆人。是說聲我看別人：種事沒有對他。
<br />
降或是要找小孩卡啊啊啊，又會相處包的喜歡到一，亮了道為什說過勞神奇人真的，有什網址啦是下還有五条悟村裡有，我真的會有一⋯她們很大開始了明年每次。理所有興趣文不也很的有，想要理中道怎麼同人認識沒有這麼，有就就這樣前是。竟是都本來不能自己小朋友，起來了嗚嗚嗚說不。
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.head_left').click(function() {
        $('.box_left').toggleClass('box_left_clicked');
        /*
        if($('.box_left').hasClass('box_left_clicked') == true) {
            $('.video_play').css('left', '58%');
        } else {
            $('.video_play').css('left', '48%');
        }
         */
    });

    setInterval(function() {
        if($('body').width() < 500) {
            $('.head_left').css('margin-top', '3px');
            $('.logo1').css('width', '40px');
            //$('.head_right').css('font-size', '14px');
            $('.head_right').css('margin-top', '0px');
            $('.video_play').css('left', '44%');
            $('.video_pause').css('left', '44%');
            var h = $('.box_show3').height() / 2 + 40;
            $('.video_play').css('top', h+'px');
            $('.video_pause').css('top', h+'px');
            $('.progress_out').css('width', '75%');
        } else if($('body').width() > 1000) {
            $('.progress_out').css('width', '90%');
        } else {
            $('.head_left').css('margin-top', '10px');
            $('.logo1').css('width', '55px');
            //$('.head_right').css('font-size', '14px');
            $('.head_right').css('margin-top', '10px');
            $('.video_play').css('left', '48%');
            $('.video_pause').css('left', '48%');
            $('.video_play').css('top', '300px');
            $('.video_pause').css('top', '300px');
            $('.progress_out').css('width', '85%');
        }
    }, 500);

    setTimeout(function() {
        var video_box = $('.video_box')[0];
        var duration_min = Math.floor(video_box.duration / 60);
        var duration_sec = Math.floor(video_box.duration % 60);
        $('.total_show').text(duration_min+':'+duration_sec);

        var currentTime_min = Math.floor(video_box.currentTime / 60);
        var currentTime_sec = Math.floor(video_box.currentTime - currentTime_min * 60);
        $('.has_show').text(currentTime_min+':'+currentTime_sec);
    }, 1000);

    var only_one = true;

    $('.video_play').click(function() {
        var video_box = $('.video_box')[0];
        video_box.play();
        $('.video_play').hide();
        $('.video_pause').show();

        if(only_one == true) {
            setInterval(function() {
                var now_per = (video_box.currentTime / video_box.duration) * 100;
                $('.progress_in').css('width', now_per+'%');
                var currentTime_min = Math.floor(video_box.currentTime / 60);
                var currentTime_sec = Math.floor(video_box.currentTime - currentTime_min * 60);
                $('.has_show').text(currentTime_min+':'+currentTime_sec);
            }, 1000);
        }
        only_one = false;
    });
    $('.video_pause').click(function() {
        var video_box = $('.video_box')[0];
        video_box.pause();
        $('.video_play').show();
        $('.video_pause').hide();
    });
});
</script>
</html>

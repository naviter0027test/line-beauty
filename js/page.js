$(function () {
  if (!(/iPad|iPhone|iPod/.test(navigator.userAgent))) return
  $(document.head).append(
    '<style>*{cursor:pointer;-webkit-tap-highlight-color:rgba(0,0,0,0)}</style>'
  )
  $(window).on('gesturestart touchmove', function (evt) {
    if (evt.originalEvent.scale !== 1) {
      evt.originalEvent.preventDefault()
      document.body.style.transform = 'scale(1)'
    }
  })
  
  
})
$(document).ready(function() {
//CONTROCL player
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

//判斷A 是否BLANK
	$('a').each(function(){
		if ( $(this).attr('target') == '_blank'){
			$(this).attr('rel','noopener noreferrer');
		}
	})
	$(window).scroll(function(){
		if ($(this).scrollTop() > 50) {
			$('.wrapper_head,.logo,.wrapper_cata').addClass('active');
			$('.scrollToTop').fadeIn();
			$('.gohead').fadeOut();
		} else {
			$('.wrapper_head,.logo,.wrapper_cata').removeClass('active');
			$('.scrollToTop').fadeOut();
				$('.gohead').fadeIn();
		}

	});
	
//Click event to scroll to top
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});

//******************************************************MAINNAVI
$("iframe").wrap("<div class='video-wrapper'/>");
//document
});

$(document).on("click",".showmore",function(event) {
	event.preventDefault();
	$(this).html() == "<span>...顯示更多</span>" ? $(this).html('<span>...顯示更少</span>') : $(this).html('<span>...顯示更多</span>');
	$(this).parent().find('.box_showword').toggleClass('more');
});


//MANAGE
$(document).on("click",".manager,.boxtitle .edit",function(event) {
		event.stopPropagation();
		$(this).next($('.boxsubnav')).toggleClass('active');
		$('.boxtitle .edit').not($(this)).next($('.boxsubnav')).removeClass('active');
	});
	 
	 
$(document).on("click","html",function(event) {
	  $('.boxsubnav').removeClass('active');
});
//manage POST
$(document).on("click",".wrapper_cont.ediit",function(event) {
	   var id=$(this).attr('data-id');
	   var url = "addnews.php?cata="+id; 
		$.get(url, function(data) { 
			$('#addnews').html(data);
		}) 
});
//MANAGE CATA
$(document).on("click",".wrapper_cont.cata",function(event) {
	  var url = "addcata.php"; 
		$.get(url, function(data) { 
			$('#addcata').html(data);
		}) 
});
$(document).on("click",".icon.cancel.caca",function(event) {
	var html='<div class="wrapper_cont cata"><div class="box-newedit"><div class="pic_edit"></div><div class="w_edit">想新增類別?</div></div></div>';
	$('#addcata').html(html);
});
$(document).on("click",".icon.ok.caca",function(event) {
	if($('#cata').val()!=""){
		 $.ajax({
						url: 'doaddcata.php',
						async: false,//for IE 
						type: 'POST',
						data: $('#formcata').serialize(),
						error: function(xhr)
						{
							alert('Ajax request error!');
						},
						success: function(response)
						{   
							if(response){
						       var html='<div class="wrapper_cont cata"><div class="box-newedit"><div class="pic_edit"></div><div class="w_edit">想新增類別?</div></div></div>';
	                           $('#addcata').html(html);
							   $(".wrapper_cont.cata:last").after(response).show().fadeIn("slow");
							}else{
								alert('gg');
							}
							
							
						}
			});
	}
});
$(document).on("click",".boxsubnav.cata .delthis",function(event) {
	    event.preventDefault();
		target = $(this).parent().parent().parent().parent();
        var id=$(this).attr('data-id');
		var action_type="delete";
        alertify.confirm("刪除類別會連同此類別貼文也刪除，您確定要刪除?", function (e) {
			  if (e) {
					$.ajax({
										url: 'dodelcata.php',
										async: false,//for IE 
										type: 'POST',
										data:{id:id,action_type:action_type},
										error: function(xhr)
										{
											alert('Ajax request error!');
										},
										success: function(response)
										{   
											if(response){
											  $(target).remove();
											}else{
											  alert("GG");
											}
											
											
										}
							});
			  } else {            
				return false; 
			  }        
		  }); 
});
$(document).on("click",".boxsubnav.cata .editthis",function(event) {
	    event.preventDefault();
		target = $(this).parent().parent().parent().parent();
        var id=$(this).attr('data-id');
		var url = "doeditcata.php?id="+id; 
		$.get(url, function(data) { 
			$(target).html(data);
		}) 
});
$(document).on("click",".icon.cancel.editcaca",function(event) {
	    event.preventDefault();
		target = $(this).parent().parent().parent();
        var id=$(this).attr('data-id');
		
		var url = "docanceleditcata.php?id="+id; 
		$.get(url, function(data) { 
			$(target).html(data);
		}) 
});
//confirmeditdata
$(document).on("click",".icon.ok.editcaca",function(event) {
	target = $(this).parent().parent().parent();
	if($('#big_name').val()!=""){
		 $.ajax({
						url: 'doeditcata2.php',
						async: false,//for IE 
						type: 'POST',
						data: $('#editformcata').serialize(),
						error: function(xhr)
						{
							alert('Ajax request error!');
						},
						success: function(response)
						{   
							if(response){
							  $(target).html(response);
							}else{
							  alert("GG");
							}
							
							
						}
		 });
	}
});

//MAGPOST
$(document).on("click",".boxsubnav.post .delthis",function(event) {
	    event.preventDefault();
		target = $(this).parent().parent().parent().parent();
        var id=$(this).attr('data-id');
		var action_type="delete";
        alertify.confirm("刪除貼文會連同貼文圖片也刪除，您確定要刪除?", function (e) {
			  if (e) {
					$.ajax({
										url: 'dopost.php',
										async: false,//for IE 
										type: 'POST',
										data:{id:id,action_type:action_type},
										error: function(xhr)
										{
											alert('Ajax request error!');
										},
										success: function(response)
										{   
											if(response){
											  $(target).remove();
											}else{
											  alert("GG");
											}
											
											
										}
							});
			  } else {            
				return false; 
			  }        
		  }); 
});
$(document).on("click",".boxsubnav.post .editthis",function(event) {
	
	    event.preventDefault();
		target = $('#addnews');
        var id=$(this).attr('data-id');
		var url = "doeditpost.php?id="+id; 
		$.get(url, function(data) { 
			$(target).html(data);
		}) 
		$('html, body').animate({scrollTop : 0},0);
});
$(document).on("click",".del.img",function(event) {
	    event.preventDefault();
		var target = $(this).parent();
        var id=$(this).attr('data-id');
		var action_type="delete";
		$.ajax({
					url: 'dodelimg.php',
					async: false,//for IE 
					type: 'POST',
					data:{id:id,action_type:action_type},
					error: function(xhr)
					{
						alert('Ajax request error!');
					},
					success: function(response)
					{   
						if(response){
						  $(target).remove();
						}else{
						  alert("GG");
						}
						
						
					}
			});;
});
$(document).on("click",".del.video",function(event) {
	    event.preventDefault();
		var target = $(this).parent();
        var id=$(this).attr('data-id');
		var action_type="delete";
		$.ajax({
					url: 'dodelvideop.php',
					async: false,//for IE 
					type: 'POST',
					data:{id:id,action_type:action_type},
					error: function(xhr)
					{
						alert('Ajax request error!');
					},
					success: function(response)
					{   
						if(response){
						  $(target).remove();
						}else{
						  alert("GG");
						}
						
						
					}
			});;
});

//chps
$(document).on("click",".chps",function(event) {
	   $('#formps').valid();
		if($('#formps').valid()){
			$.ajax({
						url: 'dochacc.php',
						async: false,//for IE 
						type: 'POST',
						data: $('#formps').serialize(),
						error: function(xhr)
						{
							alert('Ajax request error!');
						},
						success: function(response)
						{   
							if(response){
								alertify.alert(";帳號已修改,請重新登入", function (e) {  
												location.replace('logout.php');
								});
							}else{
							  alert("GG");
							}
							
							
						}
				});
		}
});
//MARQUEE
$(document).on("click",".chmarquee",function(event) {
	   $('#formmarquee').valid();
		if($('#formmarquee').valid()){
			$.ajax({
						url: 'dochmarquee.php',
						async: false,//for IE 
						type: 'POST',
						data: $('#formmarquee').serialize(),
						error: function(xhr)
						{
							alert('Ajax request error!');
						},
						success: function(response)
						{   
							if(response){
								alertify.alert("跑馬燈更新成功", function (e) {  
												location.replace('index.php');
								});
							}else{
							  alert("GG");
							}
							
							
						}
				});
		}
});
//MEM
$(document).on("click",".overlay .box .btn",function(event) {
		var url = "memlogin.php";
		$.get(url, function(data) { 
			if(data!=""){
				 $('.overlay').remove();
				 location.reload();
				};
		}) 
});

//RELOAD
$(document).on("click",".newmsg span",function(event) {
	var cata=$('#cata').val();
	var url="index.php?cata="+cata;
	location.replace(url);

});
function catchnewpost() { 
var cata=$('#cata').val();
var url = "catchnewpost.php?cata="+cata;
$.get(url, function(data) { 
	if(data!=""){
		$('.newmsg').addClass('active');
		};
}) 
} 
$(function() { 
timeID = setInterval('catchnewpost()', 100000);
}); 
//TEXTAREA
function autogrow(textarea){
var adjustedHeight=textarea.clientHeight;
    adjustedHeight=Math.max(textarea.scrollHeight,adjustedHeight);
    if (adjustedHeight>textarea.clientHeight){
        textarea.style.height=adjustedHeight+'px';
    }

}
;


$(function() {
// DOM Ready
	$(window).scroll(function(){
		if ($(this).scrollTop() >300){ //滑动300像素高时，出现返回顶部按钮
		$('#goTop').fadeIn(300);
		}else{
		$('#goTop').fadeOut(300);
		}
	});
	$("#goTop").click(function(event){
		event.preventDefault();
		jQuery("html, body").animate({ scrollTop: 0 }, 500);			
		
	});
});

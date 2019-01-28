$(document).ready(function(){
	
	//Fix Errors - http://www.learningjquery.com/2009/01/quick-tip-prevent-animation-queue-buildup/
	
	//Remove outline from links
	$("#menu li a").click(function(){
		$(this).blur();
	});
	
	//When mouse rolls over
	$("#menu li").mouseover(function(){
		$(this).stop().animate({height:'150px'},{queue:false, duration:600, easing: 'easeOutBounce'})	
		var classe = $(this).attr("class");	
		var id = "text_"+classe;
		$("#"+id).addClass(classe);
	});
	
	//When mouse is removed
	$("#menu li").mouseout(function(){
		$(this).stop().animate({height:'25px'},{queue:false, duration:600, easing: 'easeOutBounce'})
		var classe = $(this).attr("class");	
		var id = "text_"+classe;	
		$("#"+id).removeClass(classe);	
		$("#"+id).css('background-color', '#FFFFFF');
	});
	
});
$(document).ready(function(){
	$(".menu li").hover(function(){
			$(this).addClass("hover");
			$(this).children("ul li").attr('class','');
		},function(){
			$(this).removeClass("hover");  
			$(this).children("ul li").attr('class','');
		}
	); 
	$(".menu li.no_sub").hover(function(){
			$(this).addClass("hover1");
		},function(){
			$(this).removeClass("hover1");  
		}
	); 
})
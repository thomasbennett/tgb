jQuery(document).ready(function($) {

  /* for top navigation */
  $(" #menu ul ").css({display: "none"}); // Opera Fix
  $(" #menu li").hover(function(){
  $(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(400);
  },function(){
  $(this).find('ul:first').css({visibility: "hidden"});
  });
  
	$(".tabs_container").each(function(){
		$("ul.tabs",this).tabs("div.panes > div", {tabs:'li',effect: 'fade', fadeOutSpeed: -400});
	});
	$(".mini_tabs_container").each(function(){
		$("ul.mini_tabs",this).tabs("div.panes > div", {tabs:'li',effect: 'fade', fadeOutSpeed: -400});
	});
	$.tools.tabs.addEffect("slide", function(i, done) {
		this.getPanes().slideUp();
		this.getPanes().eq(i).slideDown(function()  {
			done.call();
		});
	});
  
  $(".accordion").tabs("div.pane", {tabs: '.tab', effect: 'slide'});
  	$(".toggle_title").toggle(
  		function(){
  			$(this).addClass('toggle_active');
  			$(this).siblings('.toggle_content').slideDown("fast");
  		},
  		function(){
  			$(this).removeClass('toggle_active');
  			$(this).siblings('.toggle_content').slideUp("fast");
  		}
  	);  
  /* initialize prettyphoto */
  $("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'light_square'
  });
    
	$('.sidebar-roundabout ul').roundabout({
		  shape: 'square',
		  minOpacity: 0.8,
		  minScale: 0.5,
		  duration: 1200
	   }).hover(
		function() {		
		clearInterval(interval);
		},
		function() {		
		interval = startAutoPlay();
		}
	);	

  /* Ajax Contact Form Processing */
  $('#buttonsend').click( function() {
	
	var name    = $('#name').val();
	var subject = $('#subject').val();
	var email   = $('#email').val();
	var message = $('#message').val();
	var siteurl = $('#siteurl').val();
  var sendto = $('#sendto').val();		
	
	$('.loading').fadeIn('fast');
	
	if (name != "" && subject != "" && email != "" && message != "")
		{

			$.ajax(
				{
					url: siteurl+'/sendemail.php',
					type: 'POST',
					data: "name=" + name + "&subject=" + subject + "&email=" + email + "&message=" + message+ "&sendto=" + sendto,
					success: function(result) 
					{
						$('.loading').fadeOut('fast');
						if(result == "email_error") {
							$('#email').css({"background":"#FFFCFC","border-top":"1px solid #ffb6b6","border-left":"none","border-right":"1px solid #ffb6b6","border-bottom":"none"});
						} else {
							$('#name, #subject, #email, #message').val("");
							$('.success-contact').show().fadeOut(6200, function(){ $(this).remove(); });
						}
					}
				}
			);
			return false;
			
		} 
	else 
		{
			$('.loading').fadeOut('fast');
			if( name == "") $('#name').css({"background":"#FFFCFC","border-top":"1px solid #ffb6b6","border-left":"none","border-right":"1px solid #ffb6b6","border-bottom":"none"});
			if(subject == "") $('#subject').css({"background":"#FFFCFC","border-top":"1px solid #ffb6b6","border-left":"none","border-right":"1px solid #ffb6b6","border-bottom":"none"});
			if(email == "" ) $('#email').css({"background":"#FFFCFC","border-top":"1px solid #ffb6b6","border-left":"none","border-right":"1px solid #ffb6b6","border-bottom":"none"});
			if(message == "") $('#message').css({"background":"#FFFCFC","border-top":"1px solid #ffb6b6","border-left":"none","border-right":"1px solid #ffb6b6","border-bottom":"none"});
			return false;
		}
  });

	$('#name, #subject, #email,#message').focus(function(){
		$(this).css({"background":"#ffffff","border-top":"1px solid #cccbcb","border-left":"none","border-right":"1px solid #cccbcb","border-bottom":"none"});
	});
    	
/*
* Copyright (C) 2009 Joel Sutherland.
* Liscenced under the MIT liscense
*/
(function($){$.fn.filterable=function(settings){settings=$.extend({useHash:true,animationSpeed:1000,show:{width:'show',opacity:'show'},hide:{width:'hide',opacity:'hide'},useTags:true,tagSelector:'#portfolio-filter a',selectedTagClass:'current',allTag:'all'},settings);return $(this).each(function(){$(this).bind("filter",function(e,tagToShow){if(settings.useTags){$(settings.tagSelector).removeClass(settings.selectedTagClass);$(settings.tagSelector+'[href='+tagToShow+']').addClass(settings.selectedTagClass)}$(this).trigger("filterportfolio",[tagToShow.substr(1)])});$(this).bind("filterportfolio",function(e,classToShow){if(classToShow==settings.allTag){$(this).trigger("show")}else{$(this).trigger("show",['.'+classToShow]);$(this).trigger("hide",[':not(.'+classToShow+')'])}if(settings.useHash){location.hash='#'+classToShow}});$(this).bind("show",function(e,selectorToShow){$(this).children(selectorToShow).animate(settings.show,settings.animationSpeed)});$(this).bind("hide",function(e,selectorToHide){$(this).children(selectorToHide).animate(settings.hide,settings.animationSpeed)});if(settings.useHash){if(location.hash!='')$(this).trigger("filter",[location.hash]);else $(this).trigger("filter",['#'+settings.allTag])}if(settings.useTags){$(settings.tagSelector).click(function(){$('#portfolio-list-four, #portfolio-list-three, #portfolio-list-two').trigger("filter",[$(this).attr('href')]);$(settings.tagSelector).removeClass('current');$(this).addClass('current')})}})}})(jQuery);$(document).ready(function(){$('#portfolio-list-four, #portfolio-list-three, #portfolio-list-two').filterable()});

 var imagePreview = function(){	
	/* CONFIG */
		
		xOffset = 10;
		yOffset = 30;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	$("a.preview").hover(function(e){
		this.t = this.title;
		this.title = "";	
		var c = (this.t != "") ? "<br/>" + this.t : "";
		$("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");								 
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");						
    },
	function(){
		this.title = this.t;	
		$("#preview").remove();
    });	
	$("a.preview").mousemove(function(e){
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
  };
  
  imagePreview();
  
});

function startAutoPlay() {
	return setInterval(function() {
	$('.sidebar-roundabout ul').roundabout_animateToNextChild();
	}, 6000);
}

 
jQuery(document).ready(function(){
    
    //init

    //autofill
    $('#search').autofill({ 'value':'Begin Searching...' });
    $('#s').autofill({ 'value':'Begin Searching...' });
    $('#name').autofill({ 'value':'Full Name *' });
    $('#emailaddy').autofill({ 'value':'Email Address *' });
    $('#message').autofill({ 'value':'Enter your message...' });
    
    $('#slides').cycle({
        fx : 'scrollDown',
        speedIn: 1000,
        speedOut: 700,
        timeout: 10000,
        easeIn: 'easeInExpo',
        easeOut: 'easeOutBounce',
        delay: 1000
    });

    //contact form response
    var form = $('div#contact-form');
    var response = $('div.response');
	form.submit(function(){

		var action = $(this).attr('action');
		$('.submit').attr('disabled','disabled');

		$.post(action, { 
			name: $('#name').val(),
			email: $('#email').val(),
			message: $('#message').val(),
		},
			function(data){
				form.find('div.submit').attr('disabled','');
				response.remove();
				form.after('<span class="response">'+data+'</span>');
				response.slideDown();
				if(data=='Sent') form.slideUp();
			}
		);
		return false;
	});


    // work lazyload
    /*
    $('img').lazyload({
        container: $('div#work-container'),
        effect: 'fadeIn'
    });
    */

    // work hover
    var info = $('div.info');
    var preview = $('div.preview');

    $('div.preview').find('a.open').click(function(){
        info.animate({'right':'-20px'}, 600);
        $('a.open').fadeOut(0, 600);
        return false;
    });

    //close 
    var closebtn = $('div.close');
    closebtn.click(function(){
        info.animate({'right':'-225px'}, 600);
        $('a.open').fadeIn(1, 600);
    });

    //read more link
    $('div.readMore').hide();
    $('a.more-link').click(function(){
        $('div.readMore').slideDown(600);
    });

    // work scrollTo
    $('#work-container').find('a.linkrel').click(function(){
        var href = $(this).attr('href');
        var thisID = $('#' + href + '_work'); 
        var offtop = thisID.offset().top; 

        $('html, body').animate({'scrollTop': offtop + 'px'}, 1200); 
        return false;
    });

    if($('html, body').offset().top > 800) {
        $('a.back-to-top').show(400);
    } else {
        $('a.back-to-top').hide(400);
    }

    $('a.btt').click(function(){
        $('html, body').animate({'scrollTop': '0'}, 600); 
        return false; 
    });
});

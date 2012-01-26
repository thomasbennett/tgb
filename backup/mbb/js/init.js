jQuery(document).ready(function(){
	//homepage cycle
	$('#slides').cycle({
		fx: 'fade',
		speed: 600,
		timeout: 8000,
		prev: '#prev',
		next: '#next',
		pager: '#pager',
		pause: 0,
		pagerAnchorBuilder: function(idx,slide){
			return '#pager li:eq(' + idx + ') a';
		}
	});
	
	//contact autofill
    $('#search').autofill({ 'value':'Begin Searching...' });

	//form response
	$('#contact-form').submit(function(){

		var action = $(this).attr('action');
		$('.submit').attr('disabled','disabled');

		$.post(action, { 
			name: $('#name').val(),
			email: $('#email').val(),
			phone: $('#phone').val(),
			message: $('#message').val(),
		},
			function(data){
				$('#contact-form .submit').attr('disabled','');
				$('.response').remove();
				$('#contact-form').after('<span class="response">'+data+'</span>');
				$('.response').slideDown();
				if(data=='Sent') $('#contact-form').slideUp();
			}
		);
		return false;
	});
	
});

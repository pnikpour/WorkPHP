$('document').ready(function() {

	$('.color').change(function() {
		hex = $('.color').val();
		$('body').css('backgroundColor', hex);
		$('.button').css('backgroundColor', hex);
	});

	$('.button').mouseover(function() {
		$(this).animate({backgroundColor: '#D0D0D0'}, 'fast');
	});

	$('.button').mouseleave(function() {
		$(this).animate({backgroundColor: 'black'}, 'fast');
	});

});

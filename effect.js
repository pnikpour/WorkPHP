
$('document').ready(function() {

	$('ul').mouseover(function() {
		$(this).animate({backgroundColor: '#D0D0D0'}, 'fast');
	});

	$('ul').mouseleave(function() {
		$(this).animate({backgroundColor: 'black'}, 'fast');
	});
});

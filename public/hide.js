

function hideThis(container) {
	container.animate({opacity:0}, 'slow', function() {
		container.submit();
		console.log('single');
	});
}

function hideAndShow(container, toShow) {
	container.animate({opacity:0}, 'slow', function() {
		console.log('double');
		toShow.css('visibility', 'visible');
		container.submit();
		container.remove();
	});

}

console.log('main begins...');

// var bodyWidth = $('body').scrollWidth;
// $('#body-width').innerHTML = bodyWidth;
var bodyWidth = $('body').width();
$('#body-width').text(bodyWidth);

if (typeof window[conf.func] == 'function') {
	console.log('runAfterFunction defined...');
	window[conf.func]();
}

$('.ch-section-name-container i').on('click', function() {
	$(this).parent().parent().toggleClass('is-open');
});

// gallery script
$('.gallery a').imageLightbox();


/*
var fetchImageAsync = function(img, src) {
	img.setAttribute('src', src);
}

var imgNodes = document.getElementsByTagName('img');
for (var i = 0, j = imgNodes.length; i<j; ++i) {
	// var style = imgNodes[i],
		// src = style.getAttribute('data-src');
		// sleep = style.getAttribute('data-delay');
	var src = imgNodes[i].getAttribute('data-src');
	if (src) {
		fetchImageAsync(imgNodes[i], imgNodes[i].getAttribute('data-src'));
	}
}*/

lazyload();
console.log('magic begins...');

var page = {};

if (document.location.host == 'localhost') {
	page.host = 'http://localhost/~ash';
} else {
	page.host = 'http://squarezone.pl';
}
page.urls = {
	// site: page.host + '/',
	site: page.host + '/renaissance/pub',
	ivy: 'http://admin.squarezone.pl/'
};

// $('#link-to-article').click(function(event) {
// 	$('#jump-to-article').focus();
// 	event.preventDefault();
// });

// magic in jquery
$('#jump-to-article').change(function() {
	var url = page.urls.site + 'gry/' + this.value;
	console.log(url);
	document.location.href = url;
});

// $('#jump-to-article').click(function() {
// 	$(this).change();
// });

$('#cup-form').submit(function(e) {
// $('#cup-form button').click(function(e) {
	// var self, form, score, url, player, params, parts;

	// $('.button').attr('disabled', true);

	// self = $(this);
	// form = $('#cup-form');
	// score = $('.points');
	// url = page.urls.site + '/form/vote';
	// player = parseInt($(this).attr('data-player')) - 1;
	// params = form.serialize() + '&vote=' + $(this).attr('value');

	// parts = score.text().split('-');
	// parts[player] = parseInt(parts[player]) + 1;
	
	// $.post(
 //        url,
 //        params
 //    ).then(function(data) {
 //    	console.log('req sent');

 //    	score.text(parts.join('-'));

    	// self.after('<span class="mtb" style="display: inline-block; padding: .5em;">Głos oddany!</span>').remove();
 //    });

	// e.preventDefault;
	// return false;


});

// bg-cover
var article = $('#main-text');
if (article.hasClass('bg-cover') && 'backgroundSize' in document.getElementById('main-text').style) {
	// article.addClass('fixed-cover');
	console.log('style changed');
	// alert('background-size supported');
} else {
	// alert('background-size not supported');
}

// gallery script
$('.gallery a').imageLightbox();



var fetchImageAsync = function(img, src) {
	// setTimeout(function() {
		img.setAttribute('src', src);
	// }, 3000);
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

		// if (src) {
			// if (sleep) {
			// 	style.style.display = 'none';
			// }
			// style.setAttribute('src', src);
			// style.clasname = '';
	    // }
}


// events tracking
if (typeof ga === 'function') {
	$('.site-logo').click(function() {
		ga('send', 'event', 'header - logo', 'click', 'squarezone' );
	});
	// $('.site-logo').click(function() {
	// 	ga('send', 'event', 'header - logo', 'click', $(this).text() );
	// });
	$('#auth-tgr').click(function() {
		ga('send', 'event', 'header - auth', 'click', $(this).attr('data-user-sign-in') );
	});
	$('.nav-top a').click(function() {
		ga('send', 'event', 'header - nav', 'click', $(this).text() );
	});

	$('.news-theme article a').click(function() {
		ga('send', 'event', 'front - news', 'click', $(this).children('span').text() );
	});
	$('.article-theme article a').click(function() {
		ga('send', 'event', 'front - article', 'click', $(this).children('span').text() );
	});
	$('.story-theme article a').click(function() {
		ga('send', 'event', 'front - story', 'click', $(this).children('span').text() );
	});

	$('#footer .footer-thumbnail').click(function() {
		ga('send', 'event', 'footer - image', 'click', $(this).attr('href').replace(location.protocol + '//' + location.host, '') );
	});
	$('#footer ul a').click(function() {
		ga('send', 'event', 'footer - link', 'click', $(this).attr('href').replace(location.protocol + '//' + location.host, '') );
	});	
}




// check function to run after load page and execute
// var runAfterAction = conf.func;
// console.log(conf.func + '...');
if (typeof window[conf.func] == 'function') {
	console.log('runAfterFunction defined...');
	window[conf.func]();
}


$('.ch-section-name-container i').on('click', function() {
	$(this).parent().parent().toggleClass('is-open');
});



// debug console
var debugtgr = document.getElementById('console-tgr');

if (debugtgr) {
	debugtgr.onclick = function(event) {
		var stack = document.getElementsByClasname('stack')[0];
		if (stack.style.display == 'block') {
			stack.style.display = 'none';
			ajax.get(page.urls.ivy + 'dev/reset/console');
			debugtgr.textContent = 'Konsola (pokaż)';
		} else {
			stack.style.display = 'block';
			ajax.get(page.urls.ivy + 'dev/set/console/1');
			debugtgr.textContent = 'Konsola (ukryj)';
		}
		console.log('stack: ' + stack.style.display);

		return false;
	};
}
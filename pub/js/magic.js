// magic in js
console.log('let\'s begin all magic...');

var page = {
	urls: {
		ivy: 'http://localhost/~ash/ivy/pub/'
	}
};

// ajax
var ajax = {};
ajax.x = function() {
    if (typeof XMLHttpRequest !== 'undefined') {
        return new XMLHttpRequest();  
    }
    // var versions = [
    //     "MSXML2.XmlHttp.5.0",   
    //     "MSXML2.XmlHttp.4.0",  
    //     "MSXML2.XmlHttp.3.0",   
    //     "MSXML2.XmlHttp.2.0",  
    //     "Microsoft.XmlHttp"
    // ];

    // var xhr;
    // for(var i = 0; i < versions.length; i++) {  
    //     try {  
    //         xhr = new ActiveXObject(versions[i]);  
    //         break;  
    //     } catch (e) {
    //     }  
    // }
    // return xhr;
};

ajax.send = function(url, callback, method, data, sync) {
    var x = ajax.x();
    x.open(method, url, sync);
    x.onreadystatechange = function() {
        if (x.readyState == 4) {
        	if (callback) {
	            callback(x.responseText)
	        }
        }
    };
    if (method == 'POST') {
        x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }
    x.send(data)
};

ajax.get = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    if (query.length > 0) {
    	url += '?' + query.join('&');
    }
    ajax.send(url, callback, 'GET', null, sync)
};

ajax.post = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url, callback, 'POST', query.join('&'), sync)
};



var sendAjax = function() {
	console.log('sendAjax...');

	var data = {
		dataset: {
			id_lobby: null,
			title: 'abc',
			markup: '<p>test</p>',
			markdown: 'test'
		}
	};

	ajax.post(page.urls.ivy + 'lobby/insert', data, function() {});
}






// events functions
var openOverlay = function() {
	console.log('openOverlay...');
	document.getElementById('overlay').className = '';
};
var closeOverlay = function() {
	console.log('closeOverlay...');
	document.getElementById('overlay').className = 'hidden';
};

var showAuthDialog = function() {
	console.log('showAuthDialog...');
	document.getElementById('overlay').className = '';

	return false;
};

var changeArticleCategory = function() {
	console.log('changeArticleCategory...');
	// document.getElementById('overlay').className = 'hidden';
};

var showEditForm = function() {
	console.log('showEditForm...');
	openOverlay();

	// var dialog = document.getElementById('dialog');
	var dialog = document.getElementsByClassName('dialog')[0];

	dialog.className = 'dialog full';

	var form = '<header>'
	+'				<h3>Edycja artykułu</h3>'
	+'				<span id="close-tgr" class="icon-close"></span>'
	+'			</header>'
	+'			<div>'
	+'				<form method="post" action="???">'
	+'					<div>'
	+'						<input id="form-title" id="dataset[title]" type="text" value="">'
	+'					</div>'
	+'					<div>'
	+'						<textarea id="form-markup" name="dataset[markup]" cols="80" rows="10"></textarea>'
	+'					</div>'
	+'					<div>'
	+'						<input id="send-edit-tgr" type="button" class="button color" value="Wyślij">'
	+'						<input type="button" class="button" value="Podgląd">'
	+'					</div>'
	+'				</form>'
	+'			</div>';

	dialog.innerHTML = form;

	document.getElementById('form-title').value = document.getElementById('article-title').textContent;
	document.getElementById('form-markup').value = document.getElementById('article-markup').innerHTML;

	

	// ajax.post(page.urls.ivy + 'lobby/insert', data, function() {});

	var sendEditForm = function() {

		var data = {
			dataset: {
				'dataset[id_lobby]': null,
				'dataset[id_author]': conf.user.id,
				'dataset[id_object]': document.getElementById('article-markup').getAttribute('data-id-article'),
				'dataset[object]': 'article',
				'dataset[title]': document.getElementById('form-title').value,
				'dataset[markdown]': document.getElementById('form-markup').value,
				'dataset[type]': 'proposed'
			}
		};

		ajax.post(page.urls.ivy + 'lobby/insert', data.dataset, function() {});

		closeOverlay();

		return false;
	}

	var el = document.getElementById('send-edit-tgr');
	el.addEventListener('click', sendEditForm, true);

	// rebind...
	var el = document.getElementById('close-tgr');
	el.addEventListener('click', closeOverlay, true);

/*<header>
				<h3>Edycja artykułu</h3>
				<span id="close-tgr" class="icon-close"></span>
			</header>
			<div>
				<form method="post" action="???">
					<texarea name="article"></texarea>
					<input type="submit" class="button color" value="Wyślij">
					<input type="submit" class="button" value="Podgląd">
				</form>
			</div>*/



	return false;
};
// var keyCodeEvent = function(e) {
	// if (e.key)
// };


// events binding
var el = document.getElementById('close-tgr');
el.addEventListener('click', closeOverlay, true);



var el = document.getElementById('jump-to-article');
el.addEventListener('change', changeArticleCategory, true);




// events binding
// var el = document.getElementById('auth-tgr');
// el.addEventListener('click', showAuthDialog, true);
/*var menutgr = document.getElementById('menu-tgr');

if (menutgr) {
	console.log('binding menu-list event');
	menutgr.onclick = function(event) {
		console.log('menu-tgr');
		var menu = document.getElementById('menu-list');
		if (menu.style.display == '') {
			menu.style.display = 'block';
		} else {
			menu.style.display = '';
		}
		return false;
	};
}*/

var authtgr = document.getElementById('auth-tgr');

if (authtgr) {
	authtgr.onclick = function(event) {
		console.log('auth click...');
		console.warn(this.getAttribute('data-user-sign-in'));
		
		// if (this.getAttribute('data-user-sign-in') == false) {
		if (true) {
			console.log('showAuthDialog() execututed...');
			showAuthDialog();

			// event.preventDefault;
			return false;
		}
	};
}
// el.addEventListener('click', showAuthDialog, true);


// var el = document('close-tgr');
// el.addEventListener('keyup', keyCodeEvent, true);
// document.onkeyup = function(event) {
//     if (event.keyCode == 27) {
//     	closeOverlay();
//     }
//     // if (event.keyCode == 37) {
//     // 	console.log('prev');
//     // }
//     // if (event.keyCode == 39) {
//     // 	console.log('next');
//     // }
// };

document.onselect = function(event) {
    console.log('select event');
};


var imgNodes = document.getElementsByTagName('img');
for (var i = 0, j = imgNodes.length; i < j; ++i) {
	var style = imgNodes[i],
		src = style.getAttribute('data-src');
		
		if (src) {
			console.log('set image src');
			style.setAttribute('src', src);
	    }
}


// events binding
var el = document.getElementById('close-tgr');
el.addEventListener('click', closeOverlay, true);


// run after method definitions
var runStoryInfo = function() {
	console.log('runStoryInfo() function...');

	var el = document.getElementById('edit-text-tgr');
	el.addEventListener('click', showEditForm, true);
}

var runArticleInfo = function() {
	console.log('runArticleInfo() function...');

	var el = document.getElementById('edit-text-tgr');
	if (el) {
		el.addEventListener('click', showEditForm, true);
	}
}


var imgNodes = document.getElementsByTagName('img');
for (var i = 0, j = imgNodes.length; i<j; ++i) {
	var style = imgNodes[i],
		src = style.getAttribute('data-src');
		// sleep = style.getAttribute('data-delay');
		
		if (src) {
			// if (sleep) {
			// 	style.style.display = 'none';
			// }
			style.setAttribute('src', src);
			// style.className = '';
	    }
}



// check function to run after load page and execute
// var runAfterAction = conf.func;
// console.log(conf.func + '...');
if (typeof window[conf.func] == 'function') {
	console.log('runAfterFunction defined...');
	window[conf.func]();
}




// debug console
var debugtgr = document.getElementById('console-tgr');

if (debugtgr) {
	debugtgr.onclick = function(event) {
		var stack = document.getElementsByClassName('stack')[0];
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
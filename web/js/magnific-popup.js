var getShouts = function(timestamp) {
	$.getJSON('http://localhost/~ash/renaissance/pub/shoutbox/get/timestamp/' + timestamp, function(data) {
		var items = [];
		$.each(data, function(idx, itm) {
			// console.log(itm);
			items.push('<li>'
				+ '<img class="author-on-left" src="' + '/~ash/renaissance/pub/' + 'imgs/site/red/' + itm.slug + '.png" width="50" height="50">'
				+ '<span>' + itm.name + '</span>'
				+ '<p class="shout from-left">' + itm.shout + '<time>' + itm.creation_date +'</time></p>'
				+ '</li>');
		});
		

		$(items.join('')).prependTo('.shouts');


	});

	// $.getJSON( "ajax/test.json", function( data ) {
	// 	var items = [];
	// 	$.each( data, function( key, val ) {
	// 		items.push( "<li id='" + key + "'>" + val + "</li>" );
	// 	});

	// 	$( "<ul/>", {
	// 		"class": "my-new-list",
	// 		html: items.join( "" )
	// 	}).appendTo( "body" );
	// });

	
	
};

var runShoutboxIndex = function() {
	// $('.button').click(function(event) {
	// 	console.log('click...');

	// 	$.post('http://localhost/~ash/renaissance/pub/shoutbox/insert', {
	// 		shout: $('#shout-input').text()
	// 	});

	// 	// event.preventDefault();

	// 	return false;
	// });

	$('.get-shouts').click(function() {
		getShouts(Math.floor(new Date($('.shout:eq(0) time').text()).getTime()/1000));

	});

	$('#shout-post').submit(function() {
		console.log('submit...');

		$.post('http://localhost/~ash/renaissance/pub/shoutbox/insert', {
			shout: $('#shout-input').val()
		});

		// ev.preventDefault;

		return false;
	});
}


$(document).ready(function() {
	console.log('jQuery is ready...');

	console.log('runAfterMethod is ready...');

	// console.log(conf.func());

	var runAfterAction = conf.func;
	if (typeof window[runAfterAction] == 'function') {
		window[runAfterAction]();
	}

	// intervals
	var shouting;



	var windowHeight = window.innerHeight;
	var navHeight = $('nav').innerHeight();
	// console.log(navHeight);

	$('.bg-cover header').css({'height': windowHeight - navHeight});


	$('.worker-8').click(function() {
		postRandomShout();
	});


	// shouting = setInterval(function() {
	// 	postRandomShout();
	// }, 40000);


	var runAfterShoutboxIndex = function() {
			// shouting = setInterval(function() {
			// 	postRandomShout();
			// }, 5000);
	}


	if (window.location.href == 'http://localhost/~ash/renaissance/pub/shoutbox') {
		// console.log('yes... ready to work');
		runAfterShoutboxIndex();	
	}

	var postRandomShout = function() {
		users = {
			'154': {
				'name': 'DarkButz',
				'slug': 'darkbutz'
			},
			'206': {
				'name': 'Yuzuriha',
				'slug': 'yuzuriha'
			},
			'2678': {
				'name': 'Aysnel',
				'slug': 'aysnel'
			},
			'1824': {
				'name': 'FieryBird',
				'slug': 'fierybird'
			},
			'5791': {
				'name': 'kALWa888',
				'slug': 'kalwa888'
			},
			'6': {
				'name': 'The_Reaver',
				'slug': 'the-reaver'
			},
			'2410': {
				'name': 'vigo',
				'slug': 'vigo'
			},
			'1971': {
				'name': 'Lacci',
				'slug': 'lacci'
			},
			'3028': {
				'name': 'susuwatari',
				'slug': 'susuwatari'
			},
			'1660': {
				'name': 'Anouk',
				'slug': 'anouk'
			},
			'1371': {
				'name': 'Musiolik',
				'slug': 'musiolik'
			},
			'455': {
				'name': 'Kazumaru',
				'slug': 'kazumaru'
			},
			'288': {
				'name': '_dark_cloud_',
				'slug': 'dark-cloud'
			}
		};
		var messages = [
			'o jeju, ale fajny ten nowy shoutbox :)',
			'No włąsnie też, sobie nie zawałem sprawy, ze Ash tak fanie to rozganizował',
			':)',
			'Ktoś zamierza grać w Final Fantasy XV?',
			'Słyszałem, ze nowy fajnal będzie na Xbox One',
			'to nie prawda!',
			'SquareEnix robi najlepsze gry jakie widziałam',
			'No to mało w życiu widziałaś, kobieto ;)',
			'Mnie interesuje nowa strona? Kiedy będzie, bo już sie nie mogę doczekać, aż mnie w dołku ściska',
			'A będziecie limitować długość odpowiedzi?',
			'Większe otwrcie na ludzi to byl strzał w 10',
			'Teraz tylkoczekamy na ludzi, zeby zaczeli swoją prace...',
			'Tantalus niezle ogarnia redakje :)',
			':D',
			'Ktow wie, moze znowu bedziemy najlepsi na rynku',
			'Prawo dżungli, zostaliśmy sami, bo inne serwisu umarły dawno temu :D',
			'Nasza społeczność przetrwa po wsze czasy...',
			'Ale z Was optymiści :F',
			'Bzdury... jakich wczesniej nie słyszałem',
			'Tak sie zaczynają plotki...',
			'Jeszcze nie widziałem tylu osob na shoucie',
			'Zywa dyskusja... jak nigdy :S',
			'Czy tu czasem nie buszuja jakies roboty?',
			'Albo siły obce...',
			'To naprawde dziwne...',
			'squareonze zaczyna zyc wlasnym zyciem ;)',
			'jeszcze troche i wogole znikną prawdziwi ludzie!!!'
		];
		// messages.length;
		var ids = Object.keys(users);
		var user = Math.floor(Math.random() * ids.length);
		var message = Math.floor(Math.random() * messages.length);

		console.log('user: ' + user);
		console.log('message: ' + message);

		console.log('user: ' + users[ids[user]].slug);
		console.log('message: ' + messages[message]);

		

		// $.ajax({
		// 	type: 'POST',
		// 	url: 'http://localhost/~ash/renaissance/pub/shoutbox/insert',
		// 	context: document.body,
		// 	contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		// 	data: {
		// 		shout: messages[message],
		// 		id_user: users[user]
		// 	}
		// }).done(function() {
		// 	// $( this ).addClass( "done" );
		// 	console.log('shout posted...');
		// });

		$.post('http://localhost/~ash/renaissance/pub/shoutbox/insert', {
			shout: messages[message],
			id_user: ids[user],
			name: users[ids[user]].name,
			slug: users[ids[user]].slug,
		});
	};
});
var extend = function() {
	for (var i = 1; i < arguments.length; i++) {
		for (var key in arguments[i]) {
			if (arguments[i].hasOwnProperty(key)) {
				arguments[0][key] = arguments[i][key];
			}
		}
	}
	return arguments[0];
};

var listCriteria = function (context) {
	var html = '<legend>Search Criteria</legend';
	$('#criteria').html(html);
	html = 'Set: ' + context.set + '&nbsp;&nbsp;';
	if (typeof $('#setTotal').val() != 'undefined') {
		html += 'Set Total: ' + $('#setTotal').val() + '&nbsp;&nbsp;';
	}
	html += 'Limit: ' + context.limit + '&nbsp;&nbsp;';
	html += 'Sort: ' + context.sort + ' - ' + context.order + '&nbsp;&nbsp;';
	if (typeof context.genre != 'undefined' && context.genre != '') {
		html += 'Genre: ' + context.genre + '&nbsp;&nbsp;';
	}
	if (typeof context.keywords != 'undefined' && context.keywords != '') {
		html += 'Keywords: ' + context.keywords + '&nbsp;&nbsp;';
	}
	$('#criteria').append(html);
};

var getMovies = function (context) {
	var defaults = {
			limit: 20,
			set: 1,
			quality: '1080p',
			rating: 0,
			keywords: '',
			genre: '',
			sort: 'rating',
			order: 'asc'
		},
		context = extend(defaults, context);
	listCriteria(context);
	// set option vals
	$('#limitSelect').val(context.limit);
	$('#qualitySelect').val(context.quality);
	$('#ratingSelect').val(context.rating);
	$('#genreSelect').val(context.genre);
	$('#sortSelect').val(context.sort);
	$('#orderSelect').val(context.order);
	
	// do the lookup
	$.ajax({
		data: context,
		dataType: 'json',
		type: 'GET',
		url: 'http://yify-torrents.com/api/list.json',
		beforeSend: function (jqXHR, textStatus) {
			html = '<legend>Results</legend>' + 
				'<table id="data" cellspacing="0" cellpadding="0" border="1"></table>';
			$('#results').html(html);
			html = '<legend>Status</legend>' +
				'AJAX request initiated!<br />';
			$('#status').html(html);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$('#status').append('<span style="color: red;">' + textStatus + ' :: ' + errorThrown + '</span><br />');
		},
		success: function (data, textStatus, jqXHR) {
			var html = '', row = '', sets = 1, movie;
			if (data.MovieList.length > 0) {
				if (data.MovieCount == 1) {
					html += data.MovieCount + ' movie matches your criteria...<br />';
				} else {
					html += data.MovieCount + ' movies match your criteria...<br />';
					// how many sets do we have?
					if (data.MovieCount > 0) {
						sets = (data.MovieCount / context.limit);
						//$('#status').append('sets ' + (Math.ceil(sets)) + "<br />");
					}
				}
				$('#results').prepend(html);
				if (data.MovieCount > context.limit) {
					limitOptions = '';
					if (data.MovieCount > 10) {
						limitOptions += '<option value="10">10</option>';
					}
					if (data.MovieCount > 25) {
						limitOptions += '<option value="25">25</option>';
					}
					if (data.MovieCount > 50) {
						limitOptions += '<option value="50">50</option>';
						limitOptions += '<option value="ALL">ALL</option>';
					}
 
					$('#limitSelect').html(limitOptions);
					html = '';
					html += '<input type="hidden" id="limit" value="' + context.limit + '" />';
					html += '<input type="hidden" id="set" value="' + context.set + '" />';
					html += '<input type="hidden" id="quality" value="' + context.quality + '" />';
					html += '<input type="hidden" id="sort" value="' + context.sort + '" />';
					html += '<input type="hidden" id="order" value="' + context.order + '" />';
					html += '<input type="hidden" id="setTotal" value="' + sets + '" />';
						
					if (context.set > 1) {
						html += '<button id="first">First</button>';
						html += '<button id="prev">Previous</button>';
					}
					if (context.set < sets) {
						html += '<button id="next">Next</button>';
						html += '<button id="last">Last</button>';
					}
					$('#results').append(html);
				}
				for (var i = 0; i < data.MovieList.length; i++) {
					movie = data.MovieList[i];
					row = '<tr>';
					row += '<td style="text-align: left;">' + movie.MovieTitleClean + '</td>';
					row += '<td>' + movie.MovieYear + '</td>';
					row += '<td>' + movie.Quality + '</td>';
					row += '<td>' + movie.Genre + '</td>';
					row += '<td>' + movie.MovieRating + '</td>';
					row += '</tr>';
					$('#data').append(row);
				}
			}
		},
		complete: function (jqXHR, textStatus) {
			$('#status').append('AJAX request complete!<br />');
		}
	});
};
			
$(document).on('click', 'button', function() {
	var setTotal = $('#setTotal').val(),
		context = {
			limit : $('#limit').val(),
			set : $('#set').val(),
			quality : $('#quality').val(),
			sort : $('#sort').val(),
			order : $('#order').val()
		};
	
	switch (this.id) {
		case 'first':
			context.set = 1;
			break;
		case 'prev':
			context.set = parseInt(context.set, 10) -1;
			break;
		case 'next':
			context.set = parseInt(context.set, 10) + 1;
			break;
		case 'last':
			context.set = parseInt(setTotal, 10);
			break;
	}
	getMovies(context);
});

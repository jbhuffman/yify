<?php
// timer block
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

$title = 'YIFY Torrents AVI';
$html = '';

/*
$all = false;
if (array_key_exists('all', $_GET) && intval($_GET['all']) == 1) {
	$all = true;
}
$fileIn = '/Users/jbhuffman/avis';
// open for reading only, place pointer at beginning of file
$fpIn = fopen($fileIn, 'r');

$columns = array(
	'MovieID', 'CoverImage', 'State', 'MovieTitleClean',
	'MovieYear', 'DateUploaded', 'Quality', 
	'ImdbCode', 'ImdbLink', 'Size', 'MovieRating', 'Genre',
	'Downloaded', 'TorrentPeers',  'TorrentSeeds', 'TorrentHash', 'Options'
);
$fields = array(
	'MovieID', 'CoverImage', 'State', 'MovieUrl', 'MovieTitleClean',
	'MovieYear', 'DateUploaded', 'Quality', 
	'ImdbCode', 'ImdbLink', 'Size', 'SizeByte', 'MovieRating', 'Genre', 'TorrentSeeds',
	'Downloaded', 'TorrentPeers', 'TorrentUrl', 'TorrentHash', 'TorrentMagnetUrl'
);
// build request
$url = 'http://yify-torrents.com/api/list.json?';
// build output
$html .= '<table border="1" width="100%"><thead><tr>';
foreach ($columns as $column) {
	$html .= '<th>' . $column . '</th>';
}
$html .= '</tr></thead><tbody>';
$lineNum = 1;

$queryString = array(
	$keywords => 'keywords=',
	$sort => 'sort=rating',
	$genre => 'genre=',
	$rating => 'rating=0',	
	$limit => 'limit=5',
	$quality => 'quality=1080p'
);

$result = sendRequest($url.'?'.implode('&',$queryString));
exit($result);

if ($all) {
} else {
	if ($fpIn) {
		while ($line = fgets($fpIn)) {
			$line = trim($line);
			if (empty($line)) {
				continue;
			}
			$movie = str_replace(array("_"), "%20", $line);
			if (empty($movie)) {
				echo 'title empty' . "\n";
				continue;
			}
			$keywords[] = $movie;
			$lineNum++;
		}
		if (count($keywords) > 0) {
		}	
		fclose($fpIn);
	} else {
		echo 'could not open ' . $fileIn . ' or ' . $fileOut;
	}
}

$return = sendRequest($url.$keywords);
$result = json_decode($return);
		
if ($result->status == 'fail') {
	continue;
} else {
	foreach ($result->MovieList as $entry) {
		$html .= '<tr>';
		foreach ($columns as $column) {
 			switch ($column) {
 				case 'State':
 					$html .= '<td align="center">';
 					if ($entry->{$column} == 'OK') {
	 					$icon = 'tick.png';
	 				} else {
	 					$icon = 'slash.png';
	 				}
 					$html .= '<img src="img/icons/fugue-icons-3.0/'.$icon.'" />';
 					$html .= '</td>';
					break; 						
 				case 'MovieTitleClean':
 					$html .= '<td>';
 					$html .= '<a target="_blank" href="' . $entry->MovieUrl . '">' . 
 						$entry->{$column} . '</a>';
 					$html .= '</td>';
 					break;
 				case 'ImdbLink':
 					$html .= '<td align="center">';
 					$html .= '<a target="_blank" href="' . $entry->{$column} . '">';
 					$html .= '<img src="http://ia.media-imdb.com/images/M/MV5BMTgyOTIzMTA0NV5BMl5BcG5nXkFtZTcwMTA3MDg2OA@@._V1_.png" />';
 					$html .= '</a>';
 					$html .= '</td>';
 					break;
 				case 'CoverImage':
 					$html .= '<td align="center">';
 					$html .= '<img height="100" src="' . $entry->{$column} . '" />';
 					$html .= '</td>';
 					break;
 				case 'Options':
 					$html .= '<td align="center">';
 					$html .= '<a target="_blank" href="' . 
 						$entry->TorrentMagnetUrl . '">';
 					$html .= '<img src="img/icons/fugue-icons-3.0/magnet.png" />';
 					$html .= '</a>';
 					$html .= '<a target="_blank" href="' . $entry->TorrentUrl . 
 						'">';
 					$html .= '<img height="32px" src="img/icons/torrent.jpg" />'; 
 					$html .= '</a>';
 					$html .= '</td>';
 					break;
 				default: 
					$html .= '<td>';
 					$html .= $entry->{$column};
 					$html .= '</td>';
 					break;
 			 }
 		}
 		$html .= '</tr>';
	}
}
$html .= '</tbody></table>';
*/
// timer block
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
$html .= 'Page generated in ' . $total_time . ' seconds.'; ?>
<?php
/*
<!DOCTYPE html>
<html lang='en'>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="yify.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>
	<body>
		<h1><?php echo $title; ?></h1>
		<hr />
		<fieldset id="criteria"></fieldset>
		<fieldset id="options">
			Page Size
			<select id="limitSelect"></select>
			Genres
			<select id="genreSelect">
				<option value="All">All</option>
				<option value="Action">Action</option>
				<option value="Adventure">Adventure</option>
				<option value="Animation">Animation</option>
				<option value="Biography">Biography</option>
				<option value="Comedy">Comedy</option>
				<option value="Crime">Crime</option>
				<option value="Documentary">Documentary</option>
				<option value="Drama">Drama</option>
				<option value="Family">Family</option>
				<option value="Fantasy">Fantasy</option>
				<option value="Film-Noir">Film-Noir</option>
				<option value="History">History</option>
				<option value="Horror">Horror</option>
				<option value="Music">Music</option>
				<option value="Musical">Musical</option>
				<option value="Mystery">Mystery</option>
				<option value="Romance">Romance</option>
				<option value="Sci-Fi">Sci-Fi</option>
				<option value="Sport">Sport</option>
				<option value="Thriller">Thriller</option>
				<option value="War">War</option>
				<option value="Western">Western</option>
			</select>
			Quality
			<select id="qualitySelect">
				<option value="1080p">1080p</option>
			</select>
			Rating
			<select id="ratingSelect">
				<option value="0">0+</option>
				<option value="1">1+</option>
				<option value="2">2+</option>
				<option value="3">3+</option>
				<option value="4">4+</option>
				<option value="5">5+</option>
				<option value="6">6+</option>
				<option value="7">7+</option>
				<option value="8">8+</option>
				<option value="9">9+</option>
			</select>
			Sort
			<select id="sortSelect">
				<option value="date">Date</option>
				<option value="alphabet">Alphabet</option>
				<option value="year">Year</option>
			</select>
			Order
			<select id="orderSelect">
				<option value="asc" selected="selected">ASC</option>
				<option value="desc">DESC</option>
			</select>
		</fieldset>
		<fieldset id="results"></fieldset>
		<fieldset id="status"><legend>Status</legend></fieldset>
		<hr /><?php echo $html; ?>
		<script src="yify.js"></script>
		<script>
			$(window).load(function() {
				var context = {
					limit: 50,
					set: 1,
					sort: 'alphabet' 
				};
				getMovies(context);
			});

		</script>
	</body>
</html>
*/
$url = 'http://api-public.netflix.com/catalog/titles';
$curl = curl_init($url);
curl_exec($curl);
curl_close($curl);

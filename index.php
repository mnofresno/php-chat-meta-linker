<?php

header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');
$key = @$_GET['key'];
$value = @$_GET['value'];
$url = decode(@$_GET['url']);
$description = decode(@$_GET['description']);
$title = @$_GET['title'];

function decode($str) {
	return @urldecode(base64_decode($str));
}

function saveData($data_array) {
	file_put_contents('/tmp/data.serialized', serialize($data_array), LOCK_EX);
}

$data = @file_get_contents('/tmp/data.serialized');
$data_array = unserialize($data);

if (!$data_array) {
	$data_array = ['dict_values' => []];
}

if ($value) {
	$time = microtime(true);
	$key = substr(md5($value.$time), 0, 5);
        $data_array['dict_values'][$key]=['data' => $value, 'time' => $time];
	$actual_link = (getallheaders())['destination-url'];
	echo $actual_link.'?key='.$key;
} else if ($key) {
	$item = @$data_array['dict_values'][$key];
	if ($item) {
		$encodedUrl = $item['data'];
		$decodedUrl = decode($encodedUrl);
		header("Location: $decodedUrl");
		exit();	
	}
	?>
		<html>
			<head>
				<title>This page redirection no longer exists</title>
			</head>
			<body>
				<h1>The redirection has expired and is no longer working. Sorry!</h1>
			</body>
		</html>
	<?php
}

foreach ($data_array['dict_values'] as $index => $item) {
	if (microtime(true) - $item['time'] > 3600) {
		unset($data_array['dict_values'][$index]);
	}
}
saveData($data_array);
if(!$url) {
	exit();
}

header( "refresh:2;url=$url" );

?>


<html>
	<head>
		<title><?php echo $description; ?></title>
		<meta charset="UTF-8">
		<meta name="title" content="<?php echo 'URL: ' . $url; ?>">
		<meta property="og:description" content="<?php echo $description; ?>" />
		<meta property="og:title" content="<?php echo $title; ?>" />
	</head>
	<body>
		<h1>Redirecting in 2 seconds to: <?php echo $url; ?></h1>
		<h2><?php echo $description; ?></h2>
	</body>
</html>

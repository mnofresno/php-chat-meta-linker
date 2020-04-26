<?php
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');
$key = @$_GET['key'];
$value = @$_GET['value'];
$option = @$_GET['option'];
$url = @base64_decode(@$_GET['url']);
$description = base64_decode(@$_GET['description']);
$title = @$_GET['title'];

function saveData($data_array) {
	file_put_contents(__DIR__.'/data.serialized', serialize($data_array));
}
$data = @file_get_contents(__DIR__.'/data.serialized');
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
	$item = $data_array['dict_values'][$key];
	$encodedUrl = $item['data'];
	$decodedUrl = base64_decode($encodedUrl);
	header("Location: $decodedUrl");
	exit();
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
		<title><? echo $title; ?></title>
		<meta charset="UTF-8">
		<meta name="title" content="<?php echo 'URL: ' . $url; ?>">
		<meta property="og:description" content="<?php echo $description; ?>" />
		<meta property="og:title" content="<?php echo $title; ?>" />
	</head>
	<body>
		<h1>Redirecting in 2 seconds to: <?php echo $url; ?></h1>
	</body>
</html>



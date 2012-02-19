<?php

$pathinfo = pathinfo(__FILE__);

define('DS', '/');
define('PATH', $pathinfo['dirname'] . DS);
define('EXT', '.' . $pathinfo['extension']);

require PATH . 'classes/hyperlight/hyperlight'. EXT;
require PATH . 'classes/helpers'. EXT;

function render($tpl, $data = array()) {
	extract($data);

	require PATH . 'includes/header' . EXT;
	require PATH . $tpl . EXT;
	require PATH . 'includes/footer' . EXT;
}

// get uri
$uri = isset($_GET['p']) ? $_GET['p'] : false;
$segments = empty($uri) ? array() : explode(DS, trim($uri, DS));

if(empty($segments)) {
	$segments = array('home');
}

$page = array_shift($segments);

// docs
if($page == 'docs' and empty($segments)) {
	$page = 'docs/start';
} elseif($page == 'docs' and count($segments)) {
	$page = 'docs/' . array_shift($segments);
}

// themes
if($page == 'themes' and empty($segments)) {
	$page = 'themes/index';
} elseif($page == 'themes' and count($segments)) {
	$page = 'themes/' . array_shift($segments);
}

if(file_exists(PATH . 'pages/' . $page . EXT) === false) {
	header("HTTP/1.0 404 Not Found");
	$page = '404';
}

$data = array(
	'title' => 'Make blogging beautiful',
	'page' => $page,
	'menu' => array('features', 'docs', 'themes', 'forum', 'download'),
	'segments' => $segments
);

render('pages/'. $page, $data);
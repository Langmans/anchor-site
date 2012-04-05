<!doctype html>
<html lang="en-gb">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
		<title>Anchor CMS &middot; <?php echo (isset($title) ? $title : 'Page not found'); ?></title>
		<meta name="description" content="Anchor is a lightweight content management system built for art-directed content, written in PHP5.">
		<meta name="author" content="@visualidiot">
	
		<!-- http://t.co/dKP3o1e -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0">
		
		<!-- For all browsers -->
		<link rel="stylesheet" href="/assets/css/main.css">

		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
	</head>
	<body>
		<nav id="top" role="navigation">
			<a id="logo" href="/" title="Anchor CMS logo: click to go to the homepage">
				<img src="/assets/img/logo.png" alt="Anchor CMS logo">
			</a>
			<?php if(Users::authed()): ?>
			<ul>
				<?php foreach(array('themes', 'docs', 'comments', 'users', 'logout') as $link): ?>
				<?php $active = preg_match('/^\/admin\/' . $link . '/', Url::current()) ? ' class="active"' : ''; ?>
				<li<?php echo $active; ?>>
					<?php echo Html::anchor('admin/' . $link, ucwords($link)); ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</nav>
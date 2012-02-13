<!doctype html>
<html lang="en-gb">
    <head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    	<title>Anchor CMS &middot; <?php echo isset($titles[$url[0]]) ? $titles[$url[0]] : 'Make blogging beautiful'; ?></title>
    	<meta name="description" content="Anchor is a lightweight content management system built for art-directed content, written in PHP5.">
    	<meta name="author" content="@visualidiot">
    
    	<meta name="viewport" content="width=device-width,initial-scale=1">
    
    	<!-- http://t.co/dKP3o1e -->
    	<meta name="HandheldFriendly" content="True">
    	<meta name="MobileOptimized" content="320">
    	<meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0">
    	
    	<!-- For all browsers -->
    	<link rel="stylesheet" href="/assets/css/main.css">
    	
    	<!-- For those dang small screens -->
    	<link rel="stylesheet" media="only screen and (max-width: 601px)" href="/assets/css/resolutions/600.css">
    	<link rel="stylesheet" media="only screen and (max-width: 501px)" href="/assets/css/resolutions/500.css">
    	
    	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    	
    	<?php if($url[0] === 'download'): ?>
    	<meta http-equiv="refresh" content="0;url=https://github.com/visualidiot/Anchor-CMS/zipball/0.5">
    	<?php endif; ?>
    	
    	<script type="text/javascript">
    	
    	  var _gaq = _gaq || [];
    	  _gaq.push(['_setAccount', 'UA-28956662-1']);
    	  _gaq.push(['_trackPageview']);
    	
    	  (function() {
    	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    	  })();
    	
    	</script>
    </head>
    <body class="<?php echo $url[0]; ?>">
        <nav id="top" role="navigation">
            <a id="logo" href="/" title="Anchor CMS logo: click to go to the homepage">
                <img src="/assets/img/logo.png" alt="Anchor CMS logo">
            </a>
            
            <ul>
                <?php foreach($pages as $link => $title): ?>
                <li <?php if($link === $url[0]) echo 'class="active"'; ?>><a href="/<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo ucwords($link); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        

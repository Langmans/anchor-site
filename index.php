<?php

    $url = explode('/', filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING));
    
    if(empty($url[0])) {
        $url[0] = 'home';
    }
    
    function fetch($url) {
        if(file_exists($url)) {
            include_once $url;
            return true;
        }
        
        return false;
    }
    
    $page = 'pages/' . $url[0] . '.php';
    
    $pages = array(
        'features' => 'So, what makes Anchor unique?',
        'docs' => 'Learn how to make Anchor your own',
        'themes' => 'Kit out your copy of Anchor',
        'forum' => 'Discuss, debug, and deconstruct Anchor',
        'download' => 'Grab the latest version of Anchor (155kb, version 0.5a)'
    );
    
    fetch('includes/hyperlight/hyperlight.php');
    
    if($url[0] === 'docs' && !isset($url[1])) {
        $url[1] = 'start';
    }
    
    $titles = array(
        'features' => 'Features',
        'docs' => 'Documentation',
        'themes' => 'Theme Garden',
        'download' => 'Thanks for downloading!'
    );
    
    if(file_exists($page)) {
        include_once 'includes/header.php';
        include_once $page;
        include_once 'includes/footer.php';
    } else {
        $url[0] = 'not_found';
        include_once 'includes/header.php';
        include_once 'pages/404.php';
        include_once 'includes/footer.php';
    }
    

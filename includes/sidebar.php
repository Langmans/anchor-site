<?php 

    $pages = array(
        'start' => 'Getting Started',
        
        'start_sub' => array(
            'requirements' => 'Before You Install',
            'start' => 'Installing Anchor'
        ),
        
        'content' => 'Managing Content',
        
        'theming' => 'Theming Anchor',
        
        'theming_sub' => array(
            'files' => 'Theme files',
            'functions' => 'Theme functions'
        )
    );
?>

<aside id="sidebar">
    <ul>
        <?php foreach($pages as $link => $page): ?>
            
        <?php if(strpos($link, 'sub') === false): ?>
            <li <?php if($link === $url[1]) echo 'class="active"'; ?>>
                <a href="/docs/<?php echo $link; ?>"><?php echo $page; ?></a>
            
            <?php else: ?>
            
                <ul>
                    <?php foreach($page as $link => $sub): ?>
                    <li <?php if($link === $url[1]) echo 'class="active"'; ?>><a href="/docs/<?php echo $link; ?>"><?php echo $sub; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</aside>
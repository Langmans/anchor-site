<?php 

// get themes
require PATH . 'classes/themes' . EXT;

$key = end($segments);
$theme = Themes::find($key);

$url = PATH . 'submissions/' . $key . '/views.txt';
$count = file_get_contents($url) + 1;

file_put_contents($url, $count);

?>

<hgroup role="banner">
	<h1><a href="/themes">Marketplace</a></h1>
</hgroup>

<section>

    <figure class="image">
        <img src="/submissions/<?php echo $key; ?>/preview.png">
    </figure>

	<aside id="sidebar">
		<ul>
		    <?php if(file_exists(PATH . 'submissions/' . $key . $key . '.zip')): ?>
			<li><a class="download" href="/submissions/<?php echo $key; ?>/<?php echo $key; ?>.zip">Download</a></li>
			<?php else: ?>
			<li><strong class="soon">Download coming soon!</strong></li>
			<?php endif; ?>
		</ul>
		
		<dl>
		    <dt>License</dt>
		        <dd><?php echo isset($theme['license']) ? preg_replace('/\(.*\)/', '', $theme['license']) : '<a href="http://sam.zoy.org/wtfpl/COPYING">WTFPL</a>'; ?></dd>
		        
		    <dt>Author</dt>
		        <dd><a href="/themes/author/<?php echo url_title($theme['author']); ?>"><?php echo $theme['author']; ?></a></dd>
		        
		    <dt>Views</dt>
		        <dd><?php echo number_format($count); ?></dd>
		</dl>
	</aside>

	<div class="primary submission">
		<h2><?php echo $theme['name']; ?></h2>

		<p><?php echo $theme['description']; ?></p>
		<?php if(isset($theme['license'])): ?>
		<p>License: <?php echo $theme['license']; ?></p>
		<?php endif; ?>
	</div>

</section>
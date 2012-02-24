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

	<aside id="sidebar">
		<ul>
			<li><a href="/submissions/<?php echo $key; ?>/<?php echo $key; ?>.zip">Download</a></li>
		</ul>
		
		<dl>
		    <dt>License</dt>
		        <dd><?php echo isset($theme['license']) ? preg_replace('/\(.*\)/', '', $theme['license']) : '<a href="http://sam.zoy.org/wtfpl/COPYING">WTFPL</a>'; ?></dd>
		        
		    <dt>Author</dt>
		        <dd><a href="/themes/author/<?php echo url_title($theme['author']); ?>"><?php echo $theme['author']; ?></a></dd>
		        
		    <dt>Views</dt>
		        <dd><?php echo $count; ?></dd>
		</dl>
	</aside>

	<div class="primary submission">
		<figure class="prev">
		    <img src="/submissions/<?php echo $key; ?>/preview.png">
		</figure>

		<h2><?php echo $theme['name']; ?></h2>

		<p><?php echo $theme['description']; ?></p>
		<?php if(isset($theme['license'])): ?>
		<p>License: <?php echo $theme['license']; ?></p>
		<?php endif; ?>
	</div>

</section>
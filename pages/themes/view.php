<?php 

// get themes
require PATH . 'classes/themes' . EXT;

$key = end($segments);
$theme = Themes::find($key);

?>

<style>
	.submission figure {
		width: 400px;
	}
	.submission figure img {
		width: 100%;
		border: 1px solid #ddd;
		padding: 8px;
		margin-bottom: 1em;
	}
</style>

<hgroup role="banner">
	<h1>Market Place</h1>
</hgroup>

<section>

	<aside id="sidebar">
		<ul>
			<li><a href="/submissions/<?php echo $key; ?>/<?php echo $key; ?>.zip">Download</a></li>
		</ul>
	</aside>

	<div class="primary submission">
		<h2><?php echo $theme['name']; ?></h2>
		<p>by <a href="/themes/author/<?php echo url_title($theme['author']); ?>" class="author"><?php echo $theme['author']; ?></a></p>

		<figure><img src="/submissions/<?php echo $key; ?>/preview.png"></figure>
		<p><?php echo $theme['description']; ?></p>
		<?php if(isset($theme['license'])): ?>
		<p>License: <?php echo $theme['license']; ?></p>
		<?php endif; ?>
	</div>

</section>
<?php 

// get themes
require PATH . 'classes/themes' . EXT;
$themes = Themes::list_all();

?>

<hgroup role="banner">
	<h1>Marketplace</h1>
	<a href="/themes/submit">Submit your theme</a>
</hgroup>

<section>

	<ul class="submissions">
		<?php foreach($themes as $key => $theme): ?>
		<li>
			<figure>
				<a class="img" href="/themes/view/<?php echo $key; ?>">
					<img src="/submissions/<?php echo $key; ?>/preview.png">
				</a>
				<figcaption>
					<h2><a href="/themes/view/<?php echo $key; ?>" class="theme"><?php echo $theme['name']; ?></a></h2>
					<em>by <a href="/themes/author/<?php echo url_title($theme['author']); ?>" class="author"><?php echo $theme['author']; ?></a></em>
				</figcaption>
			</figure>
		</li>
		<?php endforeach; ?>
	</ul>

</section>
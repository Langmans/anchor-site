<?php 

// get themes
require PATH . 'classes/themes' . EXT;
$themes = Themes::list_all();

?>

<style>
	.submissions {
		margin: 0 0 1em 0;
		padding: 0;
		list-style-type: none;
	}
	.submissions li {
		float: left;
		width: 200px;
		margin: 10px 20px;
	}
	.submissions li figure img {
		width: 100%;
	}
	.submissions li figure figcaption {
		padding: 10px;
	}
</style>

<hgroup role="banner">
	<h1>Market Place</h1>

	<p><a href="#">Submit your theme</a></p>
</hgroup>

<section>

	<ul class="submissions">
		<?php foreach($themes as $key => $theme): ?>
		<li>
			<figure>
				<a href="/themes/view/<?php echo $key; ?>">
					<img src="/submissions/<?php echo $key; ?>/preview.png">
				</a>
				<figcaption>
					<a href="/themes/view/<?php echo $key; ?>" class="theme"><?php echo $theme['name']; ?></a> by 
					<a href="/themes/author/<?php echo url_title($theme['author']); ?>" class="author"><?php echo $theme['author']; ?></a>
				</figcaption>
			</figure>
		</li>
		<?php endforeach; ?>
	</ul>

</section>
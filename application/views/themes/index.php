<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1>Marketplace</h1>
	<a href="/themes/submit">Submit your theme</a>
</hgroup>

<section>

	<ul class="submissions">
		<?php foreach($themes as $theme): ?>
		<li>
			<figure>
				<a class="img" href="/themes/view/<?php echo $theme->id; ?>">
					<img src="/themes/thumbnail/<?php echo $theme->id; ?>">
				</a>
				<figcaption>
					<h2><a href="/themes/view/<?php echo $theme->id; ?>" class="theme"><?php echo $theme->name; ?></a></h2>
					<em>by <span class="author"><?php echo $theme->author; ?></span></em>
				</figcaption>
			</figure>
		</li>
		<?php endforeach; ?>
	</ul>

</section>

<?php View::make('layout/footer'); ?>
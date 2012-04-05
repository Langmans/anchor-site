<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1><a href="/themes">Marketplace</a></h1>
</hgroup>

<section class="themes_view">

    <figure class="image">
        <img src="/themes/preview/<?php echo $theme->id; ?>">
    </figure>

	<aside id="sidebar">
		<ul>
			<li><a class="download" href="/themes/download/<?php echo $theme->id; ?>">Download</a></li>
		</ul>
		
		<dl>
			<dt>License</dt>
				<dd><a href="http://sam.zoy.org/wtfpl/COPYING">WTFPL</a></dd>
				
			<dt>Author</dt>
				<dd><?php echo $theme->author; ?></dd>
				
			<dt>Views</dt>
				<dd><?php echo $theme->views; ?></dd>

			<dt>Downloads</dt>
				<dd><?php echo $theme->downloads; ?></dd>
		</dl>
	</aside>

	<div class="primary submission">
		<h2><?php echo $theme->name; ?></h2>
		<p><?php echo $theme->description; ?></p>
	</div>

</section>

<?php View::make('layout/footer'); ?>
<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1>Documentation</h1>
</hgroup>

<section id="content">

	<aside id="sidebar">
		<ul>
			<li><?php echo Html::anchor($url, 'Return to ' . $page->name); ?></li>
		</ul>
	</aside>
	
	<div class="primary">
		<h2><?php echo $page->title; ?></h2>

		<?php echo Html::form_open('edit/' . $page->id); ?>

			<h4>Description</h4>
			<p><?php echo Html::form_textarea(array('name' => 'html', 'class' => 'editor', 'value' => Str::entities($page->html))); ?></p>

			<h4>Example</h4>
			<p><?php echo Html::form_textarea(array('name' => 'example', 'class' => 'editor', 'value' => Str::entities($page->example))); ?></p>

			<p><?php echo Html::form_button(array('type' => 'submit'), 'Update'); ?></p>

		<?php echo Html::form_close(); ?>
	</div>
</section>

<?php View::make('layout/footer'); ?>
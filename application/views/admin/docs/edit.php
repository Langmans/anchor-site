<?php View::make('admin/layout/header'); ?>

<hgroup role="banner">
	<h1>Edit Theme</h1>
</hgroup>

<section id="content">

	<aside id="sidebar">
		<ul>
			<li><?php echo Html::anchor('docs/'. $doc->slug, 'Return to ' . $doc->name); ?></li>
		</ul>
	</aside>
	
	<div class="primary">
		<h2>Edit</h2>

		<?php echo Html::form_open('admin/docs/edit/' . $doc->id); ?>

			<?php echo Notifications::read(); ?>

			<p><label>Description<br>
			<?php echo Html::form_textarea(array('name' => 'html', 'class' => 'editor', 'value' => Str::entities($doc->html))); ?></label></p>

			<p><label>Example<br>
			<?php echo Html::form_textarea(array('name' => 'example', 'class' => 'editor', 'value' => Str::entities($doc->example))); ?></label></p>

			<p><?php echo Html::form_button(array('name' => 'submit', 'type' => 'submit'), 'Update'); ?></p>

		<?php echo Html::form_close(); ?>
	</div>
</section>

<?php View::make('admin/layout/footer'); ?>
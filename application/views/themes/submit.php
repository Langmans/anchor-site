<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1>Marketplace</h1>
</hgroup>

<section id="content">
	
	<aside id="sidebar">
		<ul>
			<li><?php echo Html::anchor('themes/help', 'Help'); ?></li>
		</ul>
	</aside>

	<div class="primary">

		<?php echo Html::form_open_multipart('themes/submit'); ?>

			<fieldset>
				<legend>Theme details</legend>

				<?php echo Notifications::read(); ?>

				<p><label>Theme<br>
				<?php echo Html::form_upload(array('name' => 'theme')); ?></label><br>
				<em>Zip archive of your theme files.</em></p>

				<p><label><?php echo Html::form_checkbox(array('name' => 'tos', 'value' => 1)); ?>
				I Agree all content submitted will be <attb>unlicense</attr>.</label></p>

				<p><?php echo Html::form_button(array('type' => 'submit'), 'Submit'); ?></p>
			</fieldset>

		<?php echo Html::form_close(); ?>

	</div>

</section>

<?php View::make('layout/footer'); ?>
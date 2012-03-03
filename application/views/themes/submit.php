<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1>Marketplace</h1>
	<a href="/themes/submit">Submit your theme</a>
</hgroup>

<section id="content">
	
	<aside id="sidebar">
		<ul>
			<li><a href="#">Help</a></li>
		</ul>
	</aside>

	<div class="primary">

		<?php echo Html::form_open('themes/submit'); ?>

			<fieldset>
				<legend>Theme details</legend>

				

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
<?php View::make('admin/layout/header'); ?>

<hgroup role="banner">
	<h1>Edit Theme</h1>
</hgroup>

<section id="content">

	<aside id="sidebar">
		<ul>
			<li><?php echo Html::anchor('admin/themes', 'Return to themes'); ?></li>
		</ul>
	</aside>
	
	<div class="primary">
		<h2>Edit Theme</h2>

		<?php echo Html::form_open('admin/themes/edit/' . $theme->id); ?>

			<?php echo Notifications::read(); ?>

			<p><label>Author<br>
			<?php echo Html::form_input(array('name' => 'author','value' => Input::post('author', $theme->author))); ?></label></p>

			<p><label>Site<br>
			<?php echo Html::form_input(array('name' => 'site','value' => Input::post('site', $theme->site))); ?></label></p>

			<p><label>Name<br>
			<?php echo Html::form_input(array('name' => 'name','value' => Input::post('name', $theme->name))); ?></label></p>

			<p><label>Description<br>
			<?php echo Html::form_input(array('name' => 'description','value' => Input::post('description', $theme->description))); ?></label></p>

			<p><label>Status<br>
			<?php echo Html::form_dropdown('status', 
				array(
					'approved' => 'approved',
					'pending' => 'pending',
					'expired' => 'expired',
					'broken' => 'broken'
				), Input::post('status', $theme->status)); ?></label></p>

			<p><?php echo Html::form_button(array('name' => 'submit', 'type' => 'submit'), 'Update'); ?>
				<?php echo Html::form_button(array('name' => 'delete', 'type' => 'submit'), 'Delete'); ?></p>

		<?php echo Html::form_close(); ?>
	</div>
</section>

<?php View::make('admin/layout/footer'); ?>
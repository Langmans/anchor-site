<?php View::make('admin/layout/header'); ?>

<hgroup role="banner">
	<h1>Login</h1>
</hgroup>

<section id="content">

	<aside id="sidebar">
		<ul>
			<li>&nbsp;</li>
		</ul>
	</aside>
	
	<div class="primary">
		<h2>Login</h2>

		<?php echo Html::form_open('admin/login'); ?>

			<?php echo Notifications::read(); ?>

			<p><label>Email address<br>
			<?php echo Html::form_input(array('name' => 'email','value' => Input::post('email'))); ?></label></p>

			<p><label>Password<br>
			<?php echo Html::form_password(array('name' => 'password')); ?></label></p>

			<p><?php echo Html::form_button(array('name' => 'submit', 'type' => 'submit'), 'Log In'); ?></p>

		<?php echo Html::form_close(); ?>
	</div>
</section>

<?php View::make('admin/layout/footer'); ?>
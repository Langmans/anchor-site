<hgroup role="banner">
	<h1>Documentation</h1>
</hgroup>

<section id="content">
	<?php require PATH . 'includes/sidebar' . EXT; ?>

	<div class="primary">

		<h2>Requirements</h2>
		<p>In order to remain lightweight, Anchor only supports recent versions of the languages it&rsquo;s written in. As such, you will need:</p>

		<ul>
		    <li>PHP 5.3 (or newer)</li>
		    <li>MySQL (and access to a database)</li>
		</ul>

		<p>If you&rsquo;re not sure what version of PHP you have, create a new file, and paste the following in at the top of the page:</p>
		<?php hyperlight('<?php echo phpversion(); ?>'); ?>

		<p>This should print a number to your screen, which should be bigger than 5.3.</p>

		<p>If you don&rsquo;t have the necessary requirements, you will not be able to install Anchor, and should contact your webhost to upgrade.</p>
	</div>
</section>
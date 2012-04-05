<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1>Documentation</h1>
</hgroup>

<section id="content">

	<?php View::make('docs/menu'); ?>
	
	<div class="primary">
		<h4>Description</h4>
		<?php echo html_entity_decode($page->html); ?>

		<?php if($page->example): ?>
		<h4>Example</h4>
		<pre><code><?php echo $page->example; ?></code></pre>
		<?php endif; ?>

		<p><em>[<?php echo Html::anchor('admin/docs/edit/' . $page->id, 'Edit this page'); ?>]</em></p>
	</div>
</section>

<script src="/assets/js/highlight.js"></script>

<?php View::make('layout/footer'); ?>
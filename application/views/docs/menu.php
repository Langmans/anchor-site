
<?php

function is_active($slug) {
	return preg_match('#' . $slug . '#', Url::current()) ? ' class="active"' : '';
}

function is_active_child($slug) {
	return preg_match('#' . $slug . '$#', Url::current()) ? ' class="active"' : '';
}

?>

<aside id="sidebar">
	<ul>
		<?php foreach(Docs::menu() as $item): ?>
		<li<?php echo is_active($item->slug); ?>>
			<?php echo Html::anchor('docs/' . $item->slug, $item->name); ?>
			<?php if(count($item->children)): ?>
			<ul>
				<?php foreach($item->children as $child): ?>
				<li<?php echo is_active_child($child->slug); ?>>
					<?php echo Html::anchor('docs/' . $item->slug . '/' . $child->slug, $child->name); ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ul>
</aside>

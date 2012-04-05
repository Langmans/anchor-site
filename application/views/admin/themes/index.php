<?php View::make('admin/layout/header'); ?>

<hgroup role="banner">
	<h1>Themes</h1>
</hgroup>

<section id="content">

	<aside id="sidebar">
		<ul>
			<li><?php echo Html::anchor('admin/themes/upload', 'Upload'); ?></li>
		</ul>
	</aside>
	
	<div class="primary">
		<?php echo Notifications::read(); ?>
		
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($themes as $theme): ?>
				<tr>
					<td><?php echo Html::anchor('admin/themes/edit/' . $theme->id, $theme->name); ?><br>
					<small><?php echo $theme->checksum; ?></small></td>
					<td><?php echo $theme->status; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>

<?php View::make('admin/layout/footer'); ?>
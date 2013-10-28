<?php $alerts = array('danger', 'success', 'info', 'warning'); ?>
<?php foreach ($alerts as $alert) : ?>
	<?php if (Session::has($alert)) : ?>
		<div class="alert alert-dismissable alert-<?= $alert?>">
			<?= Session::get($alert) ?>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>
	<?php endif ?>
<?php endforeach ?>

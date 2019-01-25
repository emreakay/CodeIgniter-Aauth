<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin/groups') ?>"><?= lang('Admin.groupsBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item active"><?= lang('Admin.breadcrumbCommonNew') ?></li>
</ol>
<?php if (session('errors')): ?>
	<div class="alert alert-danger">
		<?php foreach (session('errors') as $error) : ?>
			<?= esc($error) ?><br />
		<?php endforeach ?>
	</div>
<?php endif; ?>
<div class="card mb-3">
	<div class="card-header">
		<?= lang('Admin.groupsNewHeader') ?>
	</div>
	<?= form_open('admin/groups/create') ?>
		<div class="card-body">
			<div class="form-group">
				<label for="inputName"><?= lang('Admin.groupsLabelName') ?></label>
				<input type="text" class="form-control" name="name" id="inputName" placeholder="<?= lang('Admin.groupsLabelName') ?>" required>
			</div>
			<div class="form-group">
				<label for="inputDefinition"><?= lang('Admin.groupsLabelDefinition') ?></label>
				<input type="text" class="form-control" name="definition" id="inputDefinition" placeholder="<?= lang('Admin.groupsLabelDefinition') ?>">
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary float-right"><?= lang('Admin.groupsNewSubmit') ?></button>
			<a href="<?= site_url('admin/groups') ?>" class="btn btn-warning"><?= lang('Admin.groupsLinkBack') ?></a>
		</div>
	<?= form_close() ?>
</div>

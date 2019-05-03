<?= $this->extend('Templates/Admin') ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin/perms') ?>"><?= lang('Admin.permsBreadcrumbTitle') ?></a>
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
			<?= lang('Admin.permsNewHeader') ?>
		</div>
		<?= form_open('admin/perms/create') ?>
			<div class="card-body">
				<div class="form-group">
					<label for="inputName"><?= lang('Admin.permsLabelName') ?></label>
					<input type="text" class="form-control" name="name" id="inputName" placeholder="<?= lang('Admin.permsLabelName') ?>" required>
				</div>
				<div class="form-group">
					<label for="inputDefinition"><?= lang('Admin.permsLabelDefinition') ?></label>
					<input type="text" class="form-control" name="definition" id="inputDefinition" placeholder="<?= lang('Admin.permsLabelDefinition') ?>">
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary float-right"><?= lang('Admin.permsNewSubmit') ?></button>
				<a href="<?= site_url('admin/perms') ?>" class="btn btn-warning"><?= lang('Admin.permsLinkBack') ?></a>
			</div>
		<?= form_close() ?>
	</div>
<?= $this->endSection() ?>

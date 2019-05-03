<?= $this->extend('Templates/Admin') ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin/perms') ?>"><?= lang('Admin.permsBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('Admin.breadcrumbCommonShow') ?></li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<?= lang('Admin.permsShowHeader') ?>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label><?= lang('Admin.permsLabelId') ?></label>
				<p><?= $perm['id'] ?></p>
			</div>
			<div class="form-group">
				<label><?= lang('Admin.permsLabelName') ?></label>
				<p><?= $perm['name'] ?></p>
			</div>
			<div class="form-group">
				<label><?= lang('Admin.permsLabelDefinition') ?></label>
				<p><?= $perm['definition'] ?></p>
			</div>
		</div>
		<div class="card-footer">
			<a href="<?= site_url('admin/perms') ?>" class="btn btn-warning"><?= lang('Admin.permsLinkBack') ?></a>
		</div>
	</div>
<?= $this->endSection() ?>

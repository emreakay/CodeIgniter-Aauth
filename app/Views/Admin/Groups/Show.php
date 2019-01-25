<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin/groups') ?>"><?= lang('Admin.groupsBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item active"><?= lang('Admin.breadcrumbCommonShow') ?></li>
</ol>
<div class="card mb-3">
	<div class="card-header">
		<?= lang('Admin.groupsShowHeader') ?>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label><?= lang('Admin.groupsLabelId') ?></label>
			<p><?= $group['id'] ?></p>
		</div>
		<div class="form-group">
			<label><?= lang('Admin.groupsLabelName') ?></label>
			<p><?= $group['name'] ?></p>
		</div>
		<div class="form-group">
			<label><?= lang('Admin.groupsLabelDefinition') ?></label>
			<p><?= $group['definition'] ?></p>
		</div>
	</div>
	<div class="card-footer">
		<a href="<?= site_url('admin/groups') ?>" class="btn btn-warning"><?= lang('Admin.groupsLinkBack') ?></a>
	</div>
</div>

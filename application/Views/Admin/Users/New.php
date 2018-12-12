<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin/users') ?>"><?= lang('Admin.usersBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item active"><?= lang('Admin.breadcrumbCommonNew') ?></li>
</ol>
<div class="card mb-3">
	<?= form_open('admin/users/create') ?>
		<div class="card-body p-0">
		</div>
		<div class="card-footer">

		</div>
	</form>
</div>

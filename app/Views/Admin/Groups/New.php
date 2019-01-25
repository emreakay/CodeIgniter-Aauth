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
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputSubGroups"><?= lang('Admin.groupsLabelSubGroups') ?></label>
						<?php foreach ($groups as $group): ?>
							<input type="hidden" name="sub_groups[<?= $group['id'] ?>]" value="0">
							<div class="form-check">
								<label>
									<input type="checkbox" name="sub_groups[<?= $group['id'] ?>]" value="1" <?= ($group['id'] === 2 ? 'disabled' : ($group['id'] === 3 ? 'disabled' : '')) ?>>
									<?= $group['definition'] ?> (<?= $group['name'] ?>)
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputPerms"><?= lang('Admin.groupsLabelPerms') ?></label>
						<?php foreach ($perms as $perm): ?>
							<input type="hidden" name="perms[<?= $perm['id'] ?>]" value="0">
							<div class="form-check">
								<label>
									<input type="checkbox" name="perms[<?= $perm['id'] ?>]" value="1">
									<?= $perm['definition'] ?> (<?= $perm['name'] ?>)
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary float-right"><?= lang('Admin.groupsNewSubmit') ?></button>
			<a href="<?= site_url('admin/groups') ?>" class="btn btn-warning"><?= lang('Admin.groupsLinkBack') ?></a>
		</div>
	<?= form_close() ?>
</div>

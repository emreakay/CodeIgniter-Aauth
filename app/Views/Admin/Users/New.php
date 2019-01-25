<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin/users') ?>"><?= lang('Admin.usersBreadcrumbTitle') ?></a>
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
		<?= lang('Admin.usersNewHeader') ?>
	</div>
	<?= form_open('admin/users/create') ?>
		<div class="card-body">
			<div class="form-group">
				<label for="inputEmail"><?= lang('Admin.usersLabelEmail') ?></label>
				<input type="email" class="form-control" name="email" id="inputEmail" placeholder="<?= lang('Admin.usersLabelEmail') ?>" required>
			</div>
			<div class="form-group">
				<label for="inputUsername"><?= lang('Admin.usersLabelUsername') ?></label>
				<input type="text" class="form-control" name="username" id="inputUsername" placeholder="<?= lang('Admin.usersLabelUsername') ?>" <?= $useUsername ? 'required' : '' ?>>
			</div>
			<div class="form-group">
				<label for="inputPassword"><?= lang('Admin.usersLabelPassword') ?></label>
				<input type="password" class="form-control" name="password" id="inputPassword" placeholder="<?= lang('Admin.usersLabelPassword') ?>" required>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputGroups"><?= lang('Admin.usersLabelGroups') ?></label>
						<?php foreach ($groups as $group): ?>
							<input type="hidden" name="groups[<?= $group['id'] ?>]" value="0">
							<div class="form-check">
								<label>
									<input type="checkbox" name="groups[<?= $group['id'] ?>]" value="1" <?= ($group['id'] === 2 ? 'checked disabled' : ($group['id'] === 3 ? 'disabled' : '')) ?>>
									<?= $group['definition'] ?> (<?= $group['name'] ?>)
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputPerms"><?= lang('Admin.usersLabelPerms') ?></label>
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
			<button type="submit" class="btn btn-primary float-right"><?= lang('Admin.usersNewSubmit') ?></button>
			<a href="<?= site_url('admin/users') ?>" class="btn btn-warning"><?= lang('Admin.usersLinkBack') ?></a>
		</div>
	<?= form_close() ?>
</div>

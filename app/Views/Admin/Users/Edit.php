<?= $this->extend('Templates/Admin') ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin/users') ?>"><?= lang('Admin.usersBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('Admin.breadcrumbCommonEdit') ?></li>
	</ol>
	<?php if (session('errors')): ?>
		<div class="alert alert-danger">
			<?php foreach (session('errors') as $error) : ?>
				<?= esc($error) ?><br />
			<?php endforeach ?>
		</div>
	<?php elseif (session('infos')): ?>
		<div class="alert alert-info">
			<?php foreach (session('infos') as $info) : ?>
				<?= esc($info) ?><br />
			<?php endforeach ?>
		</div>
	<?php endif; ?>
	<div class="card mb-3">
		<div class="card-header">
			<?= lang('Admin.usersEditHeader') ?>
		</div>
		<?= form_open('admin/users/update/' . $user['id']) ?>
			<div class="card-body">
				<div class="form-group">
					<label><?= lang('Admin.usersLabelEmailCurrent') ?></label>
					<p><?= $user['email'] ?></p>
				</div>
				<div class="form-group">
					<label for="inputEmail"><?= lang('Admin.usersLabelEmail') ?></label>
					<input type="email" class="form-control" name="email" id="inputEmail" placeholder="<?= lang('Admin.usersLabelEmail') ?>">
				</div>
				<div class="form-group">
					<label><?= lang('Admin.usersLabelUsernameCurrent') ?></label>
					<p><?= $user['username'] ?></p>
				</div>
				<div class="form-group">
					<label for="inputUsername"><?= lang('Admin.usersLabelUsername') ?></label>
					<input type="text" class="form-control" name="username" id="inputUsername" placeholder="<?= lang('Admin.usersLabelUsername') ?>">
				</div>
				<div class="form-group">
					<label for="inputPassword"><?= lang('Admin.usersLabelPassword') ?></label>
					<input type="password" class="form-control" name="password" id="inputPassword" placeholder="<?= lang('Admin.usersLabelPassword') ?>">
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputGroups"><?= lang('Admin.usersLabelGroups') ?></label>
							<?php foreach ($groups as $group): ?>
								<?php $group['id'] = (int) $group['id']; ?>
								<input type="hidden" name="groups[<?= $group['id'] ?>]" value="0">
								<div class="form-check">
									<label>
										<input type="checkbox" name="groups[<?= $group['id'] ?>]" value="1" <?= ($group['id'] === 2 ? 'checked disabled' : ($group['id'] === 3 ? 'disabled' : (is_member($group['id'], $user['id']) ? 'checked' : ''))) ?>>
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
								<?php $perm['state'] = (int) $perm['state']; ?>
								<input type="hidden" name="perms[<?= $perm['id'] ?>]" value="-1">
								<div class="form-check">
									<label>
										<input type="checkbox" name="perms[<?= $perm['id'] ?>]" class="perm" <?= $perm['state'] !== -1 ? 'checked' : ''?>> <?= $perm['definition']?> (<?= $perm['name'] ?>)
									</label>
									<label>
										<input type="radio" name="perms[<?= $perm['id'] ?>]" value="1" <?= $perm['state'] === 1 ? 'checked' : ''?> <?= $perm['state'] === -1 ? 'disabled' : ''?>><?= lang('Admin.usersLabelAllow')?>
									</label>
									<label>
										<input type="radio" name="perms[<?= $perm['id'] ?>]" value="0" <?= $perm['state'] === 0 ? 'checked' : ''?> <?= $perm['state'] === -1 ? 'disabled' : ''?>><?= lang('Admin.usersLabelDeny')?>
									</label>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary float-right"><?= lang('Admin.usersEditSubmit') ?></button>
				<a href="<?= site_url('admin/users') ?>" class="btn btn-warning"><?= lang('Admin.usersLinkBack') ?></a>
			</div>
		<?= form_close() ?>
	</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script type="text/javascript">
  $(document).on('change', '.perm', function() {
	var name = $(this).attr('name');

	if ($(this).prop('checked')) {
	  $('input[type="radio"][name="'+ name + '"]').prop('checked', false).prop('disabled', false);
	  $('input[type="radio"][name="'+ name + '"]:eq(0)').prop('checked', true);
	} else {
	  $('input[type="radio"][name="'+ name + '"]').prop('checked', false).prop('disabled', true);
	}
  });
</script>
<?= $this->endSection() ?>

<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin/users') ?>"><?= lang('Admin.usersBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item active"><?= lang('Admin.breadcrumbCommonShow') ?></li>
</ol>
<div class="card mb-3">
	<div class="card-header">
		<?= lang('Admin.usersShowHeader') ?>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label><?= lang('Admin.usersLabelId') ?></label>
			<p><?= $user['id'] ?></p>
		</div>
		<div class="form-group">
			<label><?= lang('Admin.usersLabelEmail') ?></label>
			<p><?= $user['email'] ?></p>
		</div>
		<div class="form-group">
			<label><?= lang('Admin.usersLabelUsername') ?></label>
			<p><?= $user['username'] ?></p>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="inputSubGroups"><?= lang('Admin.usersLabelGroups') ?></label>
					<?php foreach ($groups as $group): ?>
						<?php if (! is_member($group['id'], $user['id'])): ?>
							<?php continue; ?>
						<?php endif; ?>
						<div class="form-check">
							<label>
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
						<?php if (! is_allowed($perm['id'], $user['id'])): ?>
							<?php continue; ?>
						<?php endif; ?>
						<div class="form-check">
							<label>
								<?= $perm['definition'] ?> (<?= $perm['name'] ?>)
							</label>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<a href="<?= site_url('admin/users') ?>" class="btn btn-warning"><?= lang('Admin.usersLinkBack') ?></a>
	</div>
</div>

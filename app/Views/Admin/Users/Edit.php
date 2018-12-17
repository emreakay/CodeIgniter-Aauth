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
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary float-right"><?= lang('Admin.usersEditSubmit') ?></button>
			<a href="<?= site_url('admin/users') ?>" class="btn btn-warning"><?= lang('Admin.usersLinkBack') ?></a>
		</div>
	<?= form_close() ?>
</div>

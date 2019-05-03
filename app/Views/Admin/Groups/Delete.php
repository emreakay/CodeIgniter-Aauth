<?= $this->extend('Templates/Admin') ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin/groups') ?>"><?= lang('Admin.groupsBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('Admin.breadcrumbCommonDelete') ?></li>
	</ol>
	<div class="card mb-3">
		<div class="card-header">
			<?= lang('Admin.groupsDeleteHeader') ?>
		</div>
		<?= form_open('admin/groups/delete/' . $group['id'], [], ['id' => $group['id']]) ?>
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
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="inputSubGroups"><?= lang('Admin.groupsLabelSubGroups') ?></label>
								<?php foreach ($groups as $group): ?>
									<?php if ((int) $group['subgroup'] !== 1): ?>
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
								<label for="inputPerms"><?= lang('Admin.groupsLabelPerms') ?></label>
								<?php foreach ($perms as $perm): ?>
									<?php if ((int) $perm['state'] !== -1): ?>
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
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary float-right"><?= lang('Admin.groupsDeleteSubmit') ?></button>
				<a href="<?= site_url('admin/groups') ?>" class="btn btn-warning"><?= lang('Admin.groupsLinkBack') ?></a>
			</div>
		<?= form_close() ?>
	</div>
<?= $this->endSection() ?>

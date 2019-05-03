<?= $this->extend('Templates/Admin') ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('Admin.permsBreadcrumbTitle') ?></li>
	</ol>
	<?php if (session('infos')): ?>
		<div class="alert alert-info">
			<?php foreach (session('infos') as $info) : ?>
				<?= esc($info) ?><br />
			<?php endforeach ?>
		</div>
	<?php endif; ?>
	<div class="card mb-3">
		<div class="card-header">
			<a href="<?= site_url('admin/perms/new') ?>" class="btn btn-sm btn-success float-right"><?= lang('Admin.permsLinkNew') ?></a>
			<div class="pt-1"><?= lang('Admin.permsIndexHeader') ?></div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table mb-0">
					<thead>
						<tr>
							<th scope="col" class="text-center"><?= lang('Admin.permsLabelId') ?></th>
							<th scope="col"><?= lang('Admin.permsLabelName') ?></th>
							<th scope="col"><?= lang('Admin.permsLabelDefinition') ?></th>
							<th scope="col"><?= lang('Admin.permsLabelCreatedAt') ?></th>
							<th scope="col"><?= lang('Admin.permsLabelUpdatedAt') ?></th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($perms as $perm): ?>
							<tr>
								<th scope="row" class="text-center"><?= $perm['id'] ?></th>
								<td><?= $perm['name'] ?></td>
								<td><?= $perm['definition'] ?></td>
								<td><?= $perm['created_at'] ?></td>
								<td><?= $perm['updated_at'] ?></td>
								<td class="text-right p-1">
									<div class="btn-group">
										<a href="<?= site_url('admin/perms/show/' . $perm['id']) ?>" class="btn btn-info"><i class="fa fa-fw fa-info-circle"></i></a>
										<a href="<?= site_url('admin/perms/edit/' . $perm['id']) ?>" class="btn btn-warning"><i class="fa fa-fw fa-pencil-alt"></i></a>
										<a href="<?= site_url('admin/perms/delete/' . $perm['id']) ?>" class="btn btn-danger"><i class="fa fa-fw fa-times"></i></a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer">
			<?= $pagerLinks ?>
		</div>
	</div>
<?= $this->endSection() ?>

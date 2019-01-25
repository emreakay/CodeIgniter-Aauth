<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item active"><?= lang('Admin.groupsBreadcrumbTitle') ?></li>
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
		<a href="<?= site_url('admin/groups/new') ?>" class="btn btn-sm btn-success float-right"><?= lang('Admin.groupsLinkNew') ?></a>
		<div class="pt-1"><?= lang('Admin.groupsIndexHeader') ?></div>
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table mb-0">
				<thead>
					<tr>
						<th scope="col" class="text-center"><?= lang('Admin.groupsLabelId') ?></th>
						<th scope="col"><?= lang('Admin.groupsLabelName') ?></th>
						<th scope="col"><?= lang('Admin.groupsLabelDefinition') ?></th>
						<th scope="col" class="text-center"><?= lang('Admin.groupsLabelSubGroups') ?></th>
						<th scope="col" class="text-center"><?= lang('Admin.groupsLabelPerms') ?></th>
						<th scope="col"><?= lang('Admin.groupsLabelCreatedAt') ?></th>
						<th scope="col"><?= lang('Admin.groupsLabelUpdatedAt') ?></th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($groups as $group): ?>
						<tr>
							<th scope="row" class="text-center"><?= $group['id'] ?></th>
							<td><?= $group['name'] ?></td>
							<td><?= $group['definition'] ?></td>
							<td class="text-center"><?= count(get_subgroups($group['id'])) ?></td>
							<td class="text-center"><?= count(get_group_perms($group['id'], 1)) ?></td>
							<td><?= $group['created_at'] ?></td>
							<td><?= $group['updated_at'] ?></td>
							<td class="text-right p-1">
								<div class="btn-group">
									<a href="<?= site_url('admin/groups/show/' . $group['id']) ?>" class="btn btn-info"><i class="fa fa-fw fa-info-circle"></i></a>
									<a href="<?= site_url('admin/groups/edit/' . $group['id']) ?>" class="btn btn-warning"><i class="fa fa-fw fa-pencil-alt"></i></a>
									<a href="<?= site_url('admin/groups/delete/' . $group['id']) ?>" class="btn btn-danger"><i class="fa fa-fw fa-times"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer">
		<?= $pager->links() ?>
	</div>
</div>

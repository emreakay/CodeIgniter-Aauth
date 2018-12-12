<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?= site_url('admin') ?>"><?= lang('Admin.homeBreadcrumbTitle') ?></a>
	</li>
	<li class="breadcrumb-item active"><?= lang('Admin.usersBreadcrumbTitle') ?></li>
</ol>
<div class="card mb-3">
	<div class="card-header">
		<a href="<?= site_url('admin/users/new') ?>" class="btn btn-sm btn-success float-right"><?= lang('Admin.usersLinkNew') ?></a>
		<div class="pt-1"><?= lang('Admin.usersIndexHeader') ?></div>
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table mb-0">
				<thead>
					<tr>
						<th scope="col"><?= lang('Admin.usersLabelId') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelEmail') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelUsername') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelBanned') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelCreatedAt') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelUpdatedAt') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelLastIPAddress') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelLastActivity') ?></th>
						<th scope="col"><?= lang('Admin.usersLabelLastLogin') ?></th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<? foreach ($users as $user): ?>
						<tr>
							<th scope="row"><?= $user['id'] ?></th>
							<td><?= $user['email'] ?></td>
							<td><?= $user['username'] ?></td>
							<td><?= $user['banned'] == 1 ? 'Yes' : 'No' ?></td>
							<td><?= $user['created_at'] ?></td>
							<td><?= $user['updated_at'] ?></td>
							<td><?= $user['last_ip_address'] ?></td>
							<td><?= $user['last_activity'] ?></td>
							<td><?= $user['last_login'] ?></td>
							<td class="text-right p-1">
								<div class="btn-group">
									<a href="<?= site_url('admin/users/show/' . $user['id']) ?>" class="btn btn-info"><i class="fa fa-fw fa-info-circle"></i></a>
									<a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning"><i class="fa fa-fw fa-pencil-alt"></i></a>
									<a href="<?= site_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-danger"><i class="fa fa-fw fa-times"></i></a>
								</div>
							</td>
						</tr>
					<? endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer">
		<?= $pager->links() ?>
	</div>
</div>

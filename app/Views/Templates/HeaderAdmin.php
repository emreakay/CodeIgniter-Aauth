<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title><?php (isset($title) ? $title : '') ?></title>
		<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
		<link href="/assets/css/sb-admin.min.css" rel="stylesheet">
		<?php if (isset($cssFiles)): ?>
			<?php foreach ($cssFiles as $cssFile): ?>
		<link href="<?= $cssFile; ?>" rel="stylesheet">
	<?php endforeach; ?>
	<?php endif; ?>
	</head>
	<body id="page-top">
		<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
			<a class="navbar-brand mr-1" href="index.html">Aauth</a>
			<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
				<i class="fas fa-bars"></i>
			</button>
			<ul class="navbar-nav ml-4">
				<li class="nav-item">
					<a href="<?= site_url() ?>">Home</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<?php if (is_loggedin()): ?>
					<li class="nav-item dropdown no-arrow">
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-user-circle fa-fw"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
							<a class="dropdown-item" href="<?= site_url('account/edit') ?>">Edit Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?= site_url('account/logout') ?>">Logout</a>
						</div>
					</li>
				<?php endif; ?>
			</ul>
		</nav>

		<div id="wrapper">
			<ul class="sidebar navbar-nav">
				<li class="nav-item <?= (uri_string() === 'admin' ? 'active' : '') ?>">
					<a class="nav-link" href="<?= site_url('admin') ?>">
						<i class="fas fa-fw fa-tachometer-alt"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="nav-item <?= (strpos(uri_string(), 'admin/users') !== false ? 'active' : '') ?>">
					<a class="nav-link" href="<?= site_url('admin/users') ?>">
						<i class="fas fa-fw fa-user"></i>
						<span>Users</span>
					</a>
				</li>
				<li class="nav-item <?= (strpos(uri_string(), 'admin/groups') !== false ? 'active' : '') ?>">
					<a class="nav-link" href="<?= site_url('admin/groups') ?>">
						<i class="fas fa-fw fa-users"></i>
						<span>Groups</span>
					</a>
				</li>
				<li class="nav-item <?= (strpos(uri_string(), 'admin/perms') !== false ? 'active' : '') ?>">
					<a class="nav-link" href="<?= site_url('admin/perms') ?>">
						<i class="fas fa-fw fa-lock"></i>
						<span>Perms</span>
					</a>
				</li>
			</ul>

			<div id="content-wrapper">
				<div class="container-fluid">

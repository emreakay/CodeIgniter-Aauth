<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title><? (isset($title) ? $title : '') ?></title>
		<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
		<link href="/assets/css/sb-admin.min.css" rel="stylesheet">
		<? if (isset($cssFiles)): ?>
		<? foreach ($cssFiles as $cssFile): ?>
		<link href="<?= $cssFile; ?>" rel="stylesheet">
	<? endforeach; ?>
	<? endif; ?>
	</head>
	<body id="page-top">
		<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
			<a class="navbar-brand mr-1" href="index.html">Aauth</a>
			<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
				<i class="fas fa-bars"></i>
			</button>
			<ul class="navbar-nav ml-auto">
				<? if (is_loggedin()): ?>
					<li class="nav-item dropdown no-arrow">
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-user-circle fa-fw"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
							<!-- <a class="dropdown-item" href="#">Settings</a> -->
							<!-- <div class="dropdown-divider"></div> -->
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
						</div>
					</li>
				<?php endif; ?>
			</ul>
		</nav>

		<div id="wrapper">
			<ul class="sidebar navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.html">
						<i class="fas fa-fw fa-tachometer-alt"></i>
						<span>Dashboard</span>
					</a>
				</li>
			</ul>

			<div id="content-wrapper">
				<div class="container-fluid">

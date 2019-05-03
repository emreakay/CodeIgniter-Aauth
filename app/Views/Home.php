<?= $this->extend('Templates/Base') ?>

<?= $this->section('content') ?>
	<h1 class="mb-5">Welcome To CodeIgniter-Aauth v3 for CodeIgniter 4.x</h1>
	<p class="lead">Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make easy some essential jobs such as login, permissions and access operations. Despite ease of use, it has also very advanced features like groupping, access management, public access etc..</p>
	<?php if(is_loggedin()): ?>
	<p>You are logged in.</p>
	<a href="<?= site_url('account') ?>" class="btn btn-primary px-5">Account Details</a>
	<?php else: ?>
	<p>You can Login now and test it.</p>
	<a href="<?= site_url('account/login') ?>" class="btn btn-primary px-5">Login</a>
	<?php endif; ?>
<?= $this->endSection() ?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?= (isset($title) ? $title : '') ?></title>
	<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link href="/assets/css/sb-admin.min.css" rel="stylesheet">
	<?php if (isset($cssFiles)): ?>
		<?php foreach ($cssFiles as $cssFile): ?>
	<link href="<?= $cssFile; ?>" rel="stylesheet">
	<?php endforeach; ?>
	<?php endif; ?>
  </head>
  <body>
	<?= $this->renderSection('content') ?>

	<script src="/assets/vendor/jquery/jquery.min.js"></script>
	<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="/assets/js/sb-admin.min.js"></script>
	<?php if (isset($jsFiles)): ?>
		<?php foreach ($jsFiles as $jsFiles): ?>
	<script type="text/javascript" src="<?= $jsFile; ?>"></script>
	<?php endforeach; ?>
	<?php endif; ?>
  </body>
</html>

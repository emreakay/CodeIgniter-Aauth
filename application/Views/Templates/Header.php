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

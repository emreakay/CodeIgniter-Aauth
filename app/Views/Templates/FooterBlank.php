
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/assets/js/sb-admin.min.js"></script>
    <? if (isset($jsFiles)): ?>
    <? foreach ($jsFiles as $jsFiles): ?>
    <script type="text/javascript" src="<?= $jsFile; ?>"></script>
	<? endforeach; ?>
	<? endif; ?>
  </body>
</html>

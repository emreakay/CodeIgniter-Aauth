        </div>

        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Aauth 2018</span>
            </div>
          </div>
        </footer>
      </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

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

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header"><?=lang('Account.registerText')?></div>
        <div class="card-body">
          <form method="POST">
			<?if (isset($errors)):?>
			<div class="alert alert-danger"><?=$errors?></div>
			<?endif;?>
			<?if (isset($infos)):?>
			<div class="alert alert-success"><?=$infos?></div>
			<?endif;?>
            <div class="form-group">
              <div class="form-label-group">
				<input type="email" name="email" id="inputEmail" class="form-control" placeholder="<?=lang('Account.registerLabelEmail')?>" required autofocus>
				<label for="inputEmail"><?=lang('Account.registerLabelEmail')?>*</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
				<input type="text" name="username" id="inputUsername" class="form-control" placeholder="<?=lang('Account.registerLabelUsername')?>" <?=($useUsername ? 'required' : '')?>>
				<label for="inputUsername"><?=lang('Account.registerLabelUsername')?><?=($useUsername ? '*' : '')?></label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="<?=lang('Account.registerLabelPassword')?>" required>
				<label for="inputPassword"><?=lang('Account.registerLabelPassword')?>*</label>
              </div>
            </div>
            <div class="form-group">
            	<p>* <?=lang('Account.registerRequired')?></p>
            </div>
			<button class="btn btn-primary btn-block" type="submit"><?=lang('Account.registerLabelSubmit')?></button>
          </form>
          <div class="text-center">
			<a class="d-block small mt-3" href="<?=site_url('account/login')?>"><?=lang('Account.registerLinkLogin')?></a>
			<a class="d-block small" href="<?=site_url('account/forgot_password')?>"><?=lang('Account.registerLinkForgotPassword')?></a>
          </div>
        </div>
      </div>
    </div>

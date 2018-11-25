    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header"><?=lang('Account.registerHeader')?></div>
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
          	<p class="small">* <?=lang('Account.registerRequired')?></p>
						<button class="btn btn-primary btn-block" type="submit"><?=lang('Account.registerLabelSubmit')?></button>
          </form>
        </div>
        <div class="card-footer">
					<div class="row">
						<div class="col-6">
							<a class="d-block small" href="<?=site_url('account/login')?>"><?=lang('Account.linkBackToLogin')?></a>
						</div>
						<div class="col-6 text-right">
							<a class="d-block small" href="<?=site_url('account/remind_password')?>"><?=lang('Account.linkRemindPassword')?></a>
						</div>
          </div>
        </div>
      </div>
    </div>

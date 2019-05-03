<?= $this->extend('Templates/Blank') ?>

<?= $this->section('content') ?>
  <div class="container">
	<div class="card card-register mx-auto mt-5">
	  <div class="card-header"><?=lang('Account.registerHeader')?></div>
	  <div class="card-body">
		<?= form_open('account/register') ?>
					<?php if (isset($errors)):?>
						<div class="alert alert-danger"><?=$errors?></div>
					<?php endif;?>
					<?php if (isset($infos)):?>
						<div class="alert alert-success"><?=$infos?></div>
					<?php endif;?>
					<?php $socialData = session('userProfile'); ?>
		  <div class="form-group">
			<div class="form-label-group">
							<input type="email" name="email" id="inputEmail" class="form-control" placeholder="<?=lang('Account.registerLabelEmail')?>" <?= isset($socialData) ? 'readonly value="' . $socialData->email . '"' : 'required autofocus' ?>>
							<label for="inputEmail"><?=lang('Account.registerLabelEmail')?>*</label>
			</div>
		  </div>
		  <div class="form-group">
			<div class="form-label-group">
							<input type="text" name="username" id="inputUsername" class="form-control" placeholder="<?=lang('Account.registerLabelUsername')?>" <?=($useUsername ? 'required' : '')?> <?= isset($socialData) ? '' : 'autofocus' ?>>
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
		<?= form_close() ?>
		<?php if (isset($providers)): ?>
			  <div class="text-center">&mdash;</div>
			<?php foreach ($providers as $provider): ?>
					<a href="<?= site_url('/account/social/register/' . $provider) ?>" class="btn btn-info btn-block"><?=lang('Account.registerLabelSocial') . $provider ?></a>
					<?php endforeach; ?>
				<?php endif; ?>
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
<?= $this->endSection() ?>

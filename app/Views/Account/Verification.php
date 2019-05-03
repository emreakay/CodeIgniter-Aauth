<?= $this->extend('Templates/Blank') ?>

<?= $this->section('content') ?>
	<div class="container">
		<div class="card card-login mx-auto mt-5">
			<div class="card-header"><?=lang('Account.verificationHeader')?></div>
			<div class="card-body">
				<?= form_open('account/verification') ?>
					<p><?=lang('Account.verificationText')?></p>
					<?php if (isset($errors)):?>
						<div class="alert alert-danger"><?=$errors?></div>
					<?php endif;?>
					<?php if (isset($infos)):?>
						<div class="alert alert-info"><?=$infos?></div>
					<?php endif;?>
					<div class="form-group">
						<div class="form-label-group">
							<input type="test" name="verification_code" id="inputVerificationCode" class="form-control" placeholder="<?=lang('Account.verificationLabelVerificationCode')?>" value="<?=$verificationCode?>" required autofocus>
							<label for="inputVerificationCode"><?=lang('Account.verificationLabelVerificationCode')?></label>
						</div>
					</div>
					<button class="btn btn-primary btn-block" type="submit"><?=lang('Account.verificationLabelSubmit')?></button>
				<?= form_close() ?>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-6">
						<a class="d-block small" href="<?=site_url('account/login')?>"><?=lang('Account.linkBackToLogin')?></a>
					</div>
					<div class="col-6 text-right">
						<a class="d-block small" href="<?=site_url('account/register')?>"><?=lang('Account.linkRegister')?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>

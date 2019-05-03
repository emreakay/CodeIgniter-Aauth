<?= $this->extend('Templates/Blank') ?>

<?= $this->section('content') ?>
	<div class="container">
		<div class="card card-login mx-auto mt-5">
			<div class="card-header"><?=lang('Account.remindPasswordHeader')?></div>
			<div class="card-body">
				<?= form_open('account/remind_password') ?>
					<p><?=lang('Account.remindPasswordText')?></p>
					<?php if (isset($errors)):?>
						<div class="alert alert-danger"><?=$errors?></div>
					<?php endif;?>
					<?php if (isset($infos)):?>
						<div class="alert alert-info"><?=$infos?></div>
					<?php endif;?>
					<div class="form-group">
						<div class="form-label-group">
							<input type="email" name="email" id="inputEmail" class="form-control" placeholder="<?=lang('Account.remindPasswordLabelEmail')?>" required autofocus>
							<label for="inputEmail"><?=lang('Account.remindPasswordLabelEmail')?></label>
						</div>
					</div>
					<button class="btn btn-primary btn-block" type="submit"><?=lang('Account.remindPasswordLabelSubmit')?></button>
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

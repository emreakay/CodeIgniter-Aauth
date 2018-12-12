<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
	<ul class="pagination justify-content-center mb-0">
		<?php if ($pager->hasPrevious()) : ?>
			<li class="page-item">
				<a href="<?= $pager->getFirst() ?>" class="page-link" aria-label="<?= lang('Pager.first') ?>">
					<span aria-hidden="true"><?= lang('Pager.first') ?></span>
				</a>
			</li>
			<li class="page-item">
				<a href="<?= $pager->getPrevious() ?>" class="page-link" aria-label="<?= lang('Pager.previous') ?>">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
		<?php endif ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li <?= $link['active'] ? 'class="page-item active"' : 'class="page-item"' ?>>
				<a href="<?= $link['uri'] ?>" class="page-link">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
			<li class="page-item">
				<a href="<?= $pager->getNext() ?>" class="page-link" aria-label="<?= lang('Pager.next') ?>">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
			<li class="page-item">
				<a href="<?= $pager->getLast() ?>" class="page-link" aria-label="<?= lang('Pager.last') ?>">
					<span aria-hidden="true"><?= lang('Pager.last') ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
</nav>

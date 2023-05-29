<?php if (session()->has('success')) : ?>
    <div class="alert alert-success alert-dismissible show fade">
        <i class="bi bi-check-circle"></i><strong>Success!</strong> <?= session('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger alert-dismissible show fade">
        <i class="bi bi-exclamation-circle"></i> <strong>Danger!</strong> <?= session('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php foreach (session('errors') as $error) : ?>
            <i class="bi bi-exclamation-triangle"></i><strong> Warning!</strong> <?= $error; ?>
        <?php endforeach ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>
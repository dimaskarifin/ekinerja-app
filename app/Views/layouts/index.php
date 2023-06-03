<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="<?= base_url(); ?>/admin/assets/css/main/app.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/assets/css/main/app-dark.css" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>signin/assets/img/favicon/favicon.ico" />

    <link rel="stylesheet" href="<?= base_url(); ?>/admin/assets/css/shared/iconly.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/admin/assets/css/pages/datatables.css" />
    <link rel="stylesheet"
        href="<?= base_url(); ?>/admin/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/assets/css/pages/fontawesome.min.css" />

    <link rel="stylesheet"
        href="<?= base_url(); ?>admin/assets/extensions/choices.js/public/assets/styles/choices.css" />

    <link rel="stylesheet" href="<?= base_url('assets/library/selectize/selectize.bootstrap5.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/library/sweetalert2/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/library/glightbox/css/glightbox.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
</head>

<body>
    <script src="<?= base_url(); ?>/admin/assets/js/initTheme.js"></script>
    <div id="app">
        <?= $this->include('layouts/sidebar'); ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3></h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= $title; ?>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <?= $this->renderSection('main-content'); ?>
                </div>
            </div>

            <?= $this->include('layouts/footer'); ?>
        </div>
    </div>
    <script src="<?= base_url(); ?>/admin/assets/js/bootstrap.js"></script>
    <script src="<?= base_url(); ?>/admin/assets/js/app.js"></script>

    <!-- Need: Apexcharts -->
    <script src="<?= base_url(); ?>/admin/assets/extensions/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/library/dataTables/datatables.min.js') ?>"></script>

    <script src="<?= base_url('assets/library/selectize/selectize.min.js') ?>"></script>
    <script src="<?= base_url('assets/library/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('assets/library/glightbox/js/glightbox.min.js') ?>"></script>

    <!-- select choice -->
    <script src="<?= base_url(); ?>admin/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="<?= base_url(); ?>admin/assets/js/pages/form-element-select.js"></script>
    <script>
    $(document).ready(function() {
        /* Get data table */
        var table = $('#table1').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/library/dataTables/indonesian.json') ?>"
            }
        })

        $('.modal').modal({
            backdrop: "static",
            keyboard: false
        });
    });
    </script>

    <?= $this->renderSection('script'); ?>

</body>

</html>
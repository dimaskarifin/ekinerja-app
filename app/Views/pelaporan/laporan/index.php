<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <h3>
                <?= $title ?>
            </h3>
        </div>
        <div class="card-body">
            <div class="row mb-3 border-bottom">
                <div class="col-md-6">
                    <h5>Filter</h5>
                    <form action="<?= base_url('laporan') ?>" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" id="kategori" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php
                                        $old_value_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
                                        if (!empty($old_value_kategori)) { ?>
                                            <option value="date" <?php if ($old_value_kategori == 'date') { ?> selected <?php } ?>>Harian</option>
                                            <option value="month" <?php if ($old_value_kategori == 'month') { ?> selected
                                                <?php } ?>>Bulan</option>
                                        <?php } else { ?>
                                            <option value="date">Harian</option>
                                            <option value="month">Bulan</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">NIK <span class="text-danger">*</span></label>
                                    <select name="nik" id="nik" class="form-select" required>
                                        <option value="">Pilih NIK</option>
                                        <?php
                                        // $old_value_nik = set_value('nik');
                                        $old_value_nik = isset($_GET['nik']) ? $_GET['nik'] : '';

                                        foreach ($users as $user) { ?>
                                            <?php if (!empty($old_value_nik)) { ?>
                                                <?php if ($user['nik'] == $old_value_nik) { ?>
                                                    <option value="<?= $user['nik'] ?>" selected><?= $user['nik'] . ' - ' . $user['nama'] ?>
                                                    </option>
                                                <?php } else { ?>
                                                    <option value="<?= $user['nik'] ?>"><?= $user['nik'] . ' - ' . $user['nama'] ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="<?= $user['nik'] ?>"><?= $user['nik'] . ' - ' . $user['nama'] ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <?php
                                    // $old_value_tanggal = set_value('tanggal');
                                    $old_value_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

                                    // if (!empty($old_value_tanggal)) {
                                    //     if (count(explode('-', $old_value_tanggal)) == 2 || count(explode(' ', $old_value_tanggal)) == 2) {
                                    //         $old_value_tanggal = date('F Y', strtotime($old_value_tanggal));
                                    //     } else {
                                    //         if (count(explode('/', $old_value_tanggal)) != 3) {
                                    //             $old_value_tanggal = date('d/m/Y', strtotime($old_value_tanggal));
                                    //         }
                                    //     }
                                    // }
                                    ?>
                                    <label for="">Tanggal <span class="text-danger">*</span></label>
                                    <input type="" name="tanggal" id="tanggal" class="form-control" placeholder="Pilih Kategori Dulu" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-grid gap-2 mt-2 mb-3">
                                            <a href="<?= base_url('laporan') ?>" class="btn btn-warning">Reset</a>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-grid gap-2 mt-2 mb-3">
                                            <button type="submit" class="btn btn-primary">Pilih</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 border-start">
                    <h5>Export</h5>
                    <a href="#" class="btn btn-info btn-export mt-4">Export</a>
                </div>
            </div>
            <!-- end row -->

            <table class="table table-bordered" id="table-laporan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kegiatan</th>
                        <th>Target</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($laporans as $laporan) { ?>
                        <tr>
                            <td>
                                <?= $no++ ?>
                            </td>
                            <td>
                                <?= $laporan['uraian_kegiatan'] ?>
                            </td>
                            <td>
                                <?= $laporan['target'] . ' ' . $laporan['satuan'] ?>
                            </td>
                            <td>
                                <?= $laporan['waktu_mulai'] ?>
                            </td>
                            <td>
                                <?= $laporan['waktu_selesai'] ?>
                            </td>
                            <td>
                                <?= $laporan['output'] ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- <div class="row mt-5 text-center">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <p class="fs-5">Pengawas Lapangan</p>
                        </div>
                        <div class="col-12 mt-4">
                            <img src="<?= base_url('assets/uploads/ttd/ttd.png') ?>" alt="" class="w-25">
                        </div>
                        <div class="col-12 mt-4">
                            <p class="fs-5 fw-bold mb-0"><?= session('nama') ?> <br> NIP. <?= random_int(11111111, 99999999) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <p class="fs-5">Kediri, <br> Pelaksana Lapangan</p>
                        </div>
                        <div class="col-12">
                            <img src="<?= base_url('assets/uploads/ttd/ttd.png') ?>" alt="" class="w-25">
                        </div>
                        <div class="col-12 mt-3">
                            <p class="fs-5 fw-bold mb-0"><?= session('nama') ?> <br> NIP. <?= random_int(11111111, 99999999) ?></p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>
<?= $this->endSection('main-content'); ?>

<?= $this->section('script'); ?>
<?= $this->include('layouts/message-alert'); ?>

<script>
    let table;
    let kategori, nik, tanggal;

    $(document).ready(function () {
        datatable();

        $("#tanggal").attr('readonly', true);

        kategori = $("#kategori").val();
        nik = $("#nik").val();
        tanggal = '<?= $old_value_tanggal ?>';

        if (kategori) {
            $('#tanggal').attr('type', kategori);
            $("#tanggal").attr('readonly', false);
            $("#tanggal").val('<?= $old_value_tanggal ?>');
        } else {
            $('#tanggal').attr('type', '');
            $("#tanggal").attr('readonly', true);
        }

        if (kategori && nik && tanggal) {
            $(".btn-export").attr('href', '<?= base_url('laporan/export-pdf') ?>'+'?kategori=' + kategori + '&nik=' + nik + '&tanggal=' + tanggal);
        }
    });

    $('#kategori').change(function (e) {
        e.preventDefault();
        let type = $(this).val();

        if (type) {
            $('#tanggal').attr('type', type);
            $("#tanggal").attr('readonly', false);
        } else {
            $('#tanggal').attr('type', '');
            $("#tanggal").attr('readonly', true);
        }
    });

    function datatable() {
        table = $('#table-laporan').DataTable({
            responsive: true,
            oLanguage: {
                sUrl: "<?= base_url('assets/library/dataTables/indonesian.json') ?>"
            }
        })
    }
</script>

<?= $this->endSection('script'); ?>
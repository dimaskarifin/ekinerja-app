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
                    <form action="<?= base_url('pelaksana/laporan') ?>" method="get">
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
                                            <option value="week" <?php if ($old_value_kategori == 'week') { ?> selected <?php } ?>>Minggu</option>
                                            <option value="month" <?php if ($old_value_kategori == 'month') { ?> selected <?php } ?>>Bulan</option>
                                        <?php } else { ?>
                                            <option value="date">Harian</option>
                                            <option value="week">Minggu</option>
                                            <option value="month">Bulan</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">NIK</label>
                                    <select name="nik" id="nik" class="form-select">
                                        <option value="">Pilih NIK</option>
                                        <?php
                                        $old_value_nik = isset($_GET['nik']) ? $_GET['nik'] : '';

                                        foreach ($users as $user) { ?>
                                            <?php if (!empty($old_value_nik)) { ?>
                                                <?php if ($user['nik'] == $old_value_nik) { ?>
                                                    <option value="<?= $user['nik'] ?>" selected>
                                                        <?= $user['nik'] . ' - ' . $user['nama'] ?>
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
                                    $old_value_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
                                    ?>
                                    <label for="">Tanggal <span class="text-danger">*</span></label>
                                    <input type="" name="tanggal" id="tanggal" class="form-control" placeholder="Pilih Kategori Dulu" required>
                                    <span><small id="keterangan"></small></span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-grid gap-2 mt-2 mb-3">
                                            <a href="<?= base_url('pelaksana/laporan') ?>" class="btn btn-warning">Reset</a>
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
                    <a href="javascript:void(0)" class="btn btn-info btn-export mt-4">Export</a>
                </div>
            </div>
            <!-- end row -->

            <table class="table table-bordered" id="table-laporan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
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
                                <?= $laporan['nama'] ?>
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
        </div>
    </div>
</section>
<?= $this->endSection('main-content'); ?>

<?= $this->section('script'); ?>
<?= $this->include('layouts/message-alert'); ?>

<script>
    let table;
    let type, kategori, nik, tanggal;

    $(document).ready(function() {
        datatable();

        $("#tanggal").attr('readonly', true);

        kategori = $("#kategori").val();
        nik = $("#nik").val();
        tanggal = '<?= $old_value_tanggal ?>';

        if (kategori) {
            $('#tanggal').attr('type', kategori);
            $("#tanggal").attr('readonly', false);
            $("#tanggal").val('<?= $old_value_tanggal ?>');
            if (kategori == 'week') {
                $("#keterangan").text(tampilkanTanggal('<?= $old_value_tanggal ?>'));
            }
        } else {
            $('#tanggal').attr('type', '');
            $("#tanggal").attr('readonly', true);
            $("#keterangan").text();
        }
    });

    $('#kategori').change(function(e) {
        e.preventDefault();
        type = $(this).val();
        kategori = $(this).val();

        if (type) {
            $('#tanggal').attr('type', type);
            $("#tanggal").attr('readonly', false);
            if (type != 'week') {
                $("#keterangan").text('');
            }
        } else {
            $("#keterangan").text('');
            $('#tanggal').attr('type', '');
            $('#tanggal').val('');
            $("#tanggal").attr('readonly', true);
        }
    });


    $("#tanggal").change(function(e) {
        e.preventDefault();

        tanggal = $(this).val();

        if (type == 'week') {
            $("#keterangan").text(tampilkanTanggal(tanggal));
        }
    });

    $("#nik").change(function(e) {
        e.preventDefault()

        nik = $(this).val();
    });

    $(".btn-export").click(function(e) {
        e.preventDefault();

        window.location.href = '<?= base_url('pelaksana/laporan/export-pdf') ?>' + '?kategori=' + kategori +
            '&nik=' +
            nik +
            '&tanggal=' + tanggal;
    });

    function datatable() {
        table = $('#table-laporan').DataTable({
            responsive: true,
            oLanguage: {
                sUrl: "<?= base_url('assets/library/dataTables/indonesian.json') ?>"
            }
        })
    }

    function tampilkanTanggal(tanggal) {
        // Mendapatkan nilai input tanggal per minggu
        var inputTanggalPerMinggu = tanggal;

        // Mendapatkan tanggal pertama dalam minggu yang dipilih
        var tahun = parseInt(inputTanggalPerMinggu.substring(0, 4));
        var minggu = parseInt(inputTanggalPerMinggu.substring(6, 8));
        var tanggalPertama = new Date(tahun, 0, (minggu - 1) * 7 + 2);

        // Membuat daftar tanggal per minggu
        var tanggalPerMinggu = [];
        for (var i = 0; i < 7; i++) {
            var tanggal = new Date(tanggalPertama.getTime() + i * 24 * 60 * 60 * 1000);
            var tanggalStr = tanggal.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/(\d+)\/(\d+)\/(\d+)/, '$3-$2-$1');
            tanggalPerMinggu.push(tanggalStr);
        }


        //   return ''tanggalPerMinggu[0] + ' - ' +tanggalPerMinggu[6];
        return `Minggu ke ${minggu} dari tahun ${tahun}, ${tanggalPerMinggu[0]} - ${tanggalPerMinggu[6]}`;
    }
</script>

<?= $this->endSection('script'); ?>
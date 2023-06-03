<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <h3>Profile User</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="table-laporan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kegiatan</th>
                        <th>Target</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
        </div>
    </div>
</section>
<?= $this->endSection('main-content'); ?>

<?= $this->section('script'); ?>
<?= $this->include('layouts/message-alert'); ?>

<script>
    let table;
    $(document).ready(function () {

    });

    function datatable()
    {
        table = $('#table-laporan').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/library/dataTables/indonesian.json') ?>"
            }
        })
    }
</script>

<?= $this->endSection('script'); ?>
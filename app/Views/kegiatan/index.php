<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <?php if (session()->get('role') == 'pelaksana') : ?>
                <a class="btn icon icon-left btn-primary" data-bs-target="#modalCreate" data-bs-toggle="modal"><i data-feather="edit"></i> Tambah Data Kegiatan</a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Uraian Kegiatan</th>
                        <th>Mulai Deadline</th>
                        <th>Selesai Deadline</th>
                        <?php if (session()->get('role') != 'tukang') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php foreach ($kegiatan as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row->uraian_kegiatan; ?></td>
                            <td><?= $row->deadline_start ? $row->deadline_start : '-' ?></td>
                            <td><?= $row->deadline_end ? $row->deadline_end : '-'  ?></td>
                            <td>
                                <?php if (session()->get('role') != 'tukang') : ?>
                                    <a class="btn icon btn-lg btn-warning" id="btnEdit" data-id="<?= $row->id ?>"><i class="bi bi-pencil-square"></i></a>
                                    <a class="btn icon btn-lg btn-danger" id="btnDelete" data-id="<?= base_url('kelola-kegiatan/delete/' . $row->id); ?>"><i class="bi bi-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--modal Create Kegiatan -->
<div class="modal fade text-left" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Tambah Data Kegiatan
                </h4>
            </div>
            <form action="<?= base_url('kelola-kegiatan/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Uraian Kegiatan</label>
                            <div class="form-group">
                                <textarea class="form-control" id="uraian_kegiatan" name="uraian_kegiatan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal Update kegiatan -->
<div class="modal fade text-left" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Update Data Kegiatan
                </h4>
            </div>
            <form action="<?= base_url('kelola-kegiatan/update') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Uraian Kegiatan</label>
                            <div class="form-group">
                                <textarea class="form-control" id="editKegiatan" name="uraian_kegiatan" rows="3" required></textarea>
                            </div>
                        </div>
                        <?php if (session()->get('role') == 'mandor') : ?>
                            <div class="col-md-6">
                                <label>Mulai Deadline</label>
                                <div class="form-group">
                                    <input type="date" id="deadline_start" name="deadline_start" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Selesai Deadline</label>
                                <div class="form-group">
                                    <input type="date" id="deadline_end" name="deadline_end" class="form-control" required>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('script'); ?>
<?= $this->include('layouts/message-alert'); ?>
<script>
    $('body').on('click', '#btnEdit', function() {
        var this_id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "<?= base_url('kelola-kegiatan/edit'); ?>",
            data: {
                id: this_id,
            },
            success: function(response) {
                $('#modalUpdate').modal('show');
                var encoded_data = response.data;
                var decoded_data = JSON.parse(atob(encoded_data));
                $('#editId').val(decoded_data.kegiatan[0].id);
                $('#editKegiatan').val(decoded_data.kegiatan[0].uraian_kegiatan);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error: ');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });

    $('body').on('click', '#btnDelete', function() {
        var this_id = $(this).data('id');

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Kembali',
        }).then((result) => {
            if (result.value) {
                window.location.href = this_id;
            }
        })
    });
</script>
<?= $this->endSection(); ?>


<?= $this->endSection(); ?>
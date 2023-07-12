<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <a class="btn icon icon-left btn-primary" data-bs-target="#modalCreate" data-bs-toggle="modal"><i data-feather="edit"></i> Tambah Data Timeline Kegiatan</a>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kegiatan</th>
                        <th>Detail Tanggal Kegiatan</th>
                        <th>Detail Kegiatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php foreach ($timelineKegiatan as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row->uraian_kegiatan; ?></td>
                            <td><?= $row->tanggal_kegiatan ?></td>
                            <td><?= $row->detail_kegiatan ?></td>
                            <td>
                                <a class="btn icon btn-lg btn-warning" id="btnEdit" data-id="<?= $row->id ?>"><i class="bi bi-pencil-square"></i></a>
                                <a class="btn icon btn-lg btn-danger" id="btnDelete" data-id="<?= base_url('tukang/kelola-timeline-kegiatan/delete/' . $row->id); ?>"><i class="bi bi-trash"></i></a>
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
                    Tambah Data Timeline Kegiatan
                </h4>
            </div>
            <form action="<?= base_url('tukang/kelola-timeline-kegiatan/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Kegiatan</label>
                            <div class="form-group">
                                <select name="kegiatan_id" id="kegiatan_id" class="form-control" data-placeholder="- Pilih Kegiatan -" required>
                                    <option value=""></option>
                                    <?php foreach ($kegiatan as $item) : ?>
                                        <option value="<?= $item->id ?>"><?= $item->uraian_kegiatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Detail Tanggal Kegiatan</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Detail Kegiatan</label>
                            <div class="form-group">
                                <textarea class="form-control" id="detail_kegiatan" name="detail_kegiatan" rows="3"></textarea>
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
                    Update Data Timeline Kegiatan
                </h4>
            </div>
            <form action="<?= base_url('tukang/kelola-timeline-kegiatan/update') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Kegiatan</label>
                            <div class="form-group">
                                <select name="kegiatan_id" id="edit_kegiatan_id" class="form-control" data-placeholder="- Pilih Kegiatan -" required>
                                    <option value=""></option>
                                    <?php foreach ($kegiatan as $item) : ?>
                                        <option value="<?= $item->id ?>"><?= $item->uraian_kegiatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Detail Tanggal Kegiatan</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="edit_tanggal_kegiatan" name="tanggal_kegiatan">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Detail Kegiatan</label>
                            <div class="form-group">
                                <textarea class="form-control" id="edit_detail_kegiatan" name="detail_kegiatan" rows="3"></textarea>
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

<?= $this->section('script'); ?>
<?= $this->include('layouts/message-alert'); ?>
<script>
    $(document).ready(function() {
        $('#kegiatan_id').selectize();
        $('#edit_kegiatan_id').selectize();
    });

    $('body').on('click', '#btnEdit', function() {
        var this_id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "<?= base_url('tukang/kelola-timeline-kegiatan/edit'); ?>",
            data: {
                id: this_id,
            },
            success: function(response) {
                $('#modalUpdate').modal('show');
                var encoded_data = response.data;
                var decoded_data = JSON.parse(atob(encoded_data));
                console.log(decoded_data);
                $('#editId').val(decoded_data.timelineKegiatan[0].id);
                $('#edit_kegiatan_id')[0].selectize.setValue(decoded_data.timelineKegiatan[0].kegiatan_id);
                $('#edit_detail_kegiatan').val(decoded_data.timelineKegiatan[0].detail_kegiatan);
                $('#edit_tanggal_kegiatan').val(decoded_data.timelineKegiatan[0].tanggal_kegiatan);
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
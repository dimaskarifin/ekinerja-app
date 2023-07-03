<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>


<section class="section">
    <div class="card">
        <div class="card-header">
            <!-- <a class="btn icon icon-left btn-primary" data-bs-target="#modalCreate" data-bs-toggle="modal"><i data-feather="edit"></i> Tambah Data Proyek</a> -->
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.Proyek</th>
                        <th>Nama Proyek</th>
                        <th>Kegiatan</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Nama Tukang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    ?>
                    <?php foreach ($proyek as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></th>
                        <td><strong><?= $row->no_proyek; ?></strong></td>
                        <td><?= $row->nama_proyek; ?></th>
                        <td><?= $row->uraian_kegiatan; ?></td>
                        <td><?= $row->tanggal_pelaksanaan; ?></td>
                        <td><?= isset($row->nama_tukang) ? $row->nama_tukang : '-'; ?></td>
                        <td>
                            <a class="btn icon btn-lg btn-warning" id="btnEdit" data-id="<?= $row->proyek_id ?>"><i
                                    class="bi bi-pencil-square"></i></a>
                            <!-- <a class="btn icon btn-lg btn-danger" id="btnDelete"
                                data-id="<?= base_url('mandor/kelola-proyek/delete/' . $row->proyek_id); ?>"><i
                                    class="bi bi-trash"></i></a> -->
                        </td>
                    </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Create Proyek
<div class="modal fade text-left" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Tambah Data Proyek
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-proyek/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>No. Proyek <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="addNoProyek" name="no_proyek" type="text" placeholder="Masukkan No. Proyek" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Pelaksana <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="pelaksana_id" id="addPelaksana" class="selectize">
                                    <?php foreach ($pelaksana as $row) : ?>
                                        <?php if (session()->get('id') === $row['id']) : ?>
                                            <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama']; ?>">
                                                <?= $row['nama'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Nama Proyek <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="addNamaProyek" name="nama_proyek" type="text" placeholder="Masukkan Nama Proyek" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Nama Mandor <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="mandor_id" id="addMandor" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($mandor as $row) : ?>
                                        <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama']; ?>">
                                            <?= $row['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Uraian Kegiatan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="kegiatan_id" id="addKegiatan" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($kegiatan as $row) : ?>
                                        <option value="<?= $row->id ?>" data-nama="<?= $row->uraian_kegiatan; ?>">
                                            <?= $row->uraian_kegiatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Target Pengerjaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="addTarget" name="target" type="number" placeholder="Masukkan Target Pengerjaan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Satuan Pengerjaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="satuan" id="addSatuan" class="selectize">
                                    <option value=""></option>
                                    <option value="M">M (Meter)</option>
                                    <option value="Km">KM (Kilometer)</option>
                                    <option value="Cm">CM (Centimeter)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" min="<?php echo date('Y-m-d', strtotime('now')); ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Selesai Pelaksanaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_selesai_pelaksanaan" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" />
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
</div> -->

<!-- modal Update Proyek -->
<div class="modal fade text-left" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Update Data Proyek
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-proyek/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>No. Proyek <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="editNoProyek" name="no_proyek" type="text" placeholder="Masukkan No. Proyek"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Pelaksana <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="pelaksana_id" id="editPelaksana" class="selectize">
                                    <?php foreach ($pelaksana as $row) : ?>
                                    <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama']; ?>">
                                        <?= $row['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Nama Proyek <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="editNamaProyek" name="nama_proyek" type="text"
                                    placeholder="Masukkan Nama Proyek" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Mandor</label>
                            <div class="form-group">
                                <select name="mandor_id" id="editMandor" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($mandor as $row) : ?>
                                    <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama']; ?>">
                                        <?= $row['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Tukang <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="tukang_id" id="editTukang" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($tukang as $row) : ?>
                                    <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama']; ?>">
                                        <?= $row['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Uraian Kegiatan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="kegiatan_id" id="editKegiatan" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($kegiatan as $row) : ?>
                                    <option value="<?= $row->id ?>" data-nama="<?= $row->uraian_kegiatan; ?>">
                                        <?= $row->uraian_kegiatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="form-label">Output Proyek</label>
                            <textarea class="form-control" id="editOutput" name="output" rows="3"
                                placeholder="-"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Target Pengerjaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="editTarget" name="target" type="number"
                                    placeholder="Masukkan Target Pengerjaan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Satuan Pengerjaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="satuan" id="editSatuan" class="selectize">
                                    <option value=""></option>
                                    <option value="M">M (Meter)</option>
                                    <option value="Km">KM (Kilometer)</option>
                                    <option value="Cm">CM (Centimeter)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" id="editPelaksanaan"
                                    min="<?php echo date('Y-m-d', strtotime('now')); ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Selesai Pelaksanaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_selesai_pelaksanaan"
                                    id="editSelesaiPelaksanaan"
                                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" />
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
$(function() {
    $('#addPelaksana').selectize({
        placeholder: "Pilih Pelaksana",
    })
    $('#addMandor').selectize({
        placeholder: "Pilih Mandor",
    });
    $('#addKegiatan').selectize({
        placeholder: "Pilih Kegiatan",
    });
    $('#addSatuan').selectize({
        placeholder: "Pilih Satuan",
    });
    $('#editPelaksana').selectize({
        placeholder: "Pilih Pelaksana",
    })
    $('#editMandor').selectize({
        placeholder: "Pilih Mandor",
    });
    $('#editTukang').selectize({
        placeholder: "Pilih Tukang",
    });
    $('#editKegiatan').selectize({
        placeholder: "Pilih Kegiatan",
    });
    $('#editSatuan').selectize({
        placeholder: "Pilih Satuan",
    });

})


$('body').on('click', '#btnEdit', function() {
    var this_id = $(this).data('id');
    $.ajax({
        type: "GET",
        url: "<?= base_url('mandor/kelola-proyek/edit'); ?>",
        data: {
            id: this_id,
        },
        success: function(response) {
            $('#modalUpdate').modal('show');
            var encoded_data = response.data;
            var decoded_data = JSON.parse(atob(encoded_data));
            console.log(decoded_data);
            $('#editId').val(decoded_data.proyek[0].id);
            $('#editNoProyek').val(decoded_data.proyek[0].no_proyek);
            $('#editNoProyek').prop('disabled', true);
            $('#editNamaProyek').val(decoded_data.proyek[0].nama_proyek);
            $('#editNamaProyek').prop('disabled', true);
            $('#editPelaksana')[0].selectize.setValue(decoded_data.proyek[0].pelaksana_id);
            $('#editPelaksana')[0].selectize.disable();
            $('#editMandor')[0].selectize.setValue(decoded_data.proyek[0].mandor_id);
            $('#editMandor')[0].selectize.disable();
            $('#editTukang')[0].selectize.setValue(decoded_data.proyek[0].tukang_id);
            $('#editKegiatan')[0].selectize.setValue(decoded_data.proyek[0].kegiatan_id);
            $('#editKegiatan')[0].selectize.disable();
            $('#editOutput').val(decoded_data.proyek[0].output);
            $('#editOutput').prop('disabled', true);
            $('#editTarget').val(decoded_data.proyek[0].target);
            $('#editTarget').prop('disabled', true);
            $('#editSatuan')[0].selectize.setValue(decoded_data.proyek[0].satuan);
            $('#editSatuan')[0].selectize.disable();
            $('#editPelaksanaan').val(decoded_data.proyek[0].tanggal_pelaksanaan);
            $('#editPelaksanaan').prop('disabled', true);
            $('#editSelesaiPelaksanaan').val(decoded_data.proyek[0].tanggal_selesai_pelaksanaan);
            $('#editSelesaiPelaksanaan').prop('disabled', true);
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
<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>


<section class="section">
    <div class="card">
        <div class="card-header">
            <a class="btn icon icon-left btn-primary" data-bs-target="#modalCreate" data-bs-toggle="modal"><i
                    data-feather="edit"></i> Tambah Data Proyek</a>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.Proyek</th>
                        <th>Nama Proyek</th>
                        <th>Kegiatan</th>
                        <th>Output</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Mandor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php foreach ($proyek as $row) : ?>
                    <td><?= $no++; ?></th>
                    <td><strong><?= $row->no_proyek; ?></strong></td>
                    <td><?= $row->nama_proyek; ?></th>
                    <td><?= $row->uraian_kegiatan; ?></td>
                    <td><?= $row->output; ?></td>
                    <td><?= $row->tanggal_pelaksanaan; ?></td>
                    <td><?= $row->tanggal_selesai_pelaksanaan; ?></td>
                    <td><?= $row->nama_mandor; ?></td>
                    <td>
                        <a class="btn icon btn-lg btn-warning" id="btnEdit" data-id="<?= $row->proyek_id ?>"><i
                                class="bi bi-pencil-square"></i></a>
                        <a class="btn icon btn-lg btn-danger" id="btnDelete"
                            data-id="<?= base_url('pelaksana/kelola-proyek/delete/' . $row->proyek_id); ?>"><i
                                class="bi bi-trash"></i></a>
                    </td>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--Modal Create Proyek -->
<div class="modal fade text-left" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Tambah Data Proyek
                </h4>
            </div>
            <form action="<?= base_url('kelola-proyek/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" value="<?= session()->get('id'); ?>" name="pelaksana_id">
                        <div class="col-md-6">
                            <label>No. Proyek <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="addNoProyek" name="no_proyek" type="text" placeholder="Masukkan No. Proyek"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Nama Proyek <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="addNamaProyek" name="nama_proyek" type="text"
                                    placeholder="Masukkan Nama Proyek" class="form-control">
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
                                <select name="id_kegiatan" id="addKegiatan" class="selectize">
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
                                <input id="addTarget" name="target" type="number"
                                    placeholder="Masukkan Target Pengerjaan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Satuan Pengerjaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input id="addSatuan" name="satuan" type="text" placeholder="Masukkan Satuan Pengerjaan"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                    min="<?php echo date('Y-m-d', strtotime('now')); ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Tanggal Selesai Pelaksanaan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
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
            <form action="<?= base_url('pelaksana/kelola-proyek/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Nama Pegawai</label>

                        </div>
                        <div class="col-md-12">
                            <label>Uraian Kegiatan</label>

                        </div>
                        <div class="col-md-12">
                            <label>Output</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="editOutput"
                                    name="output" rows="6"></textarea>
                                <label for="floatingTextarea">Output Kegiatan</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="editMulai" name="tanggal_mulai"
                                    min="<?php echo date('Y-m-d', strtotime('now')); ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="editSelesai" name="tanggal_selesai"
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
    $('#addMandor').selectize({
        placeholder: "Pilih Mandor",
    });
    $('#addKegiatan').selectize({
        placeholder: "Pilih Kegiatan",
    });
    $('#editMandor').selectize({
        placeholder: "Pilih Pegawai",
    });
    $('#editKegiatan').selectize({
        placeholder: "Pilih Kegiatan",
    });
})


$('body').on('click', '#btnEdit', function() {
    var this_id = $(this).data('id');
    // alert(this_id);
    $.ajax({
        type: "GET",
        url: "<?= base_url('pelaksana/kelola-proyek/edit'); ?>",
        data: {
            id: this_id,
        },
        success: function(response) {
            $('#modalUpdate').modal('show');
            var encoded_data = response.data;
            var decoded_data = JSON.parse(atob(encoded_data));
            // console.log(decoded_data);
            $('#editId').val(decoded_data.kinerja[0].id);
            $('#editPegawai')[0].selectize.setValue(decoded_data.kinerja[0].id_users);
            $('#editKegiatan')[0].selectize.setValue(decoded_data.kinerja[0].id_kegiatan);
            $('#editOutput').val(decoded_data.kinerja[0].output);
            $('#editMulai').val(decoded_data.kinerja[0].waktu_mulai);
            $('#editSelesai').val(decoded_data.kinerja[0].waktu_selesai);
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
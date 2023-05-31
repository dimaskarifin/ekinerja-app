<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <a class="btn icon icon-left btn-primary" data-bs-target="#modalCreate" data-bs-toggle="modal"><i
                    data-feather="edit"></i> Tambah Data Kegiatan</a>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Uraian Kegiatan</th>
                        <th>Satuan</th>
                        <th>Target</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php foreach ($kegiatan as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row->nama; ?></td>
                        <td><?= $row->uraian_kegiatan; ?></td>
                        <td><?= $row->satuan; ?></td>
                        <td><?= $row->target; ?></td>
                        <td>
                            <a class="btn icon btn-lg btn-warning" id="btnEdit" data-id="<?= $row->id_kegiatan ?>"><i
                                    class="bi bi-pencil-square"></i></a>
                            <a class="btn icon btn-lg btn-danger" id="btnDelete"
                                data-id="<?= base_url('mandor/kelola-kegiatan/delete/' . $row->id_kegiatan); ?>"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--modal Create Kegiatan -->
<div class="modal fade text-left" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Tambah Data Kegiatan
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-kegiatan/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Nama Pegawai</label>
                            <div class="form-group">
                                <select name="id_users" id="addPegawai" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($users as $row) : ?>
                                    <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama']; ?>">
                                        <?= $row['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label>Uraian Kegiatan</label>
                            <div class="form-group">
                                <textarea class="form-control" id="uraian_kegiatan" name="uraian_kegiatan"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label>Satuan</label>
                            <div class="form-group">
                                <select name="satuan" id="addSatuan" class="selectize">
                                    <option value=""></option>
                                    <option value="m">M (Meter)</option>
                                    <option value="cm">CM (CentiMeter)</option>
                                    <option value="km">KM (KiloMeter)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label>Target</label>
                            <div class="form-group">
                                <input id="target" name="target" type="text" placeholder="Masukkan Target"
                                    class="form-control">
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
<div class="modal fade text-left" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Update Data kegiatan
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-kegiatan/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <label>Nama kegiatan</label>
                    <div class="form-group">
                        <input id="editkegiatan" name="nama_kegiatan" type="text" placeholder="Masukkan Nama kegiatan"
                            class="form-control" />
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
    $('#addPegawai').selectize({
        placeholder: 'Pilih Pegawai',
        searchField: 'label',
    });
    $('#addSatuan').selectize({
        placeholder: 'Pilih Satuan',
        searchField: 'label',
        create: true
    });
})



$('body').on('click', '#btnEdit', function() {
    var this_id = $(this).data('id');
    $.ajax({
        type: "GET",
        url: "<?= base_url('mandor/kelola-kegiatan/edit'); ?>",
        data: {
            id: this_id,
        },
        success: function(response) {
            $('#modalUpdate').modal('show');
            var encoded_data = response.data;
            var decoded_data = JSON.parse(atob(encoded_data));
            $('#editId').val(decoded_data.kegiatan.id);
            $('#editkegiatan').val(decoded_data.kegiatan.nama_kegiatan);
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
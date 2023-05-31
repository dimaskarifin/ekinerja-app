<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <a class="btn icon icon-left btn-primary" data-bs-target="#modalCreate" data-bs-toggle="modal"><i data-feather="edit"></i> Tambah Data User</a>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>NIK</th>
                        <th>NAMA</th>
                        <th>Role</th>
                        <th>Pengawas</th>
                        <th>Jabatan</th>
                        <th>Bidang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php foreach ($users as $key => $val) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <div class="avatar avatar-xl me-3">
                                    <img src="<?= base_url('assets/uploads/' . $val->foto); ?>" alt="foto" srcset="" />
                                </div>
                            </td>
                            <td><strong><?= $val->nik; ?></strong></td>
                            <td><?= $val->nama; ?></td>
                            <td><?= $val->role; ?></td>
                            <td><?= $val->nama_pengawas; ?></td>
                            <td><?= $val->nama_jabatan; ?></td>
                            <td><?= $val->nama_bidang; ?></td>
                            <td>
                                <a class="btn icon btn-lg btn-warning" id="btnEdit" data-id="<?= $val->id_users ?>"><i class="bi bi-pencil-square"></i></a>
                                <a class="btn icon btn-lg btn-danger" id="btnDelete" data-id="<?= base_url('mandor/kelola-users/delete/' . $val->id_users); ?>"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--Modal Create -->
<div class="modal fade text-left" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Tambah Data Users
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-users/store') ?>" method="POST" enctype="multipart/form-data" files="true">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>NIK</label>
                            <div class="form-group">
                                <input id="addNIK" name="nik" type="number" placeholder="Masukkan NIK" class="form-control" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==16) return false;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama</label>
                            <div class="form-group">
                                <input id="addNama" name="nama" type="text" placeholder="Masukkan Nama" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Password</label>
                            <div class="form-group">
                                <input id="addPassword" name="password" type="password" placeholder="Masukkan Password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Role</label>
                            <div class="form-group">
                                <select name="role" id="addRole" class="selectize">
                                    <option value=""></option>
                                    <option value="mandor">Mandor</option>
                                    <option value="pelaksana">Pelaksana</option>
                                    <option value="tukang">Tukang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Foto User</label>
                            <div class="form-group">
                                <input id="addFoto" name="foto" type="file" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Pengawas</label>
                            <div class="form-group">
                                <select name="pengawas_id" id="addPengawas" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($pengawas as $row) : ?>
                                        <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama_pengawas']; ?>">
                                            <?= $row['nama_pengawas'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Jabatan</label>
                            <div class="form-group">
                                <select name="jabatan_id" id="addJabatan" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($jabatan as $row) : ?>
                                        <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama_jabatan']; ?>">
                                            <?= $row['nama_jabatan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Bidang</label>
                            <div class="form-group">
                                <select name="bidang_id" id="addBidang" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($bidang as $row) : ?>
                                        <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama_bidang']; ?>">
                                            <?= $row['nama_bidang'] ?></option>
                                    <?php endforeach; ?>
                                </select>
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

<!-- modal Update users -->
<div class="modal fade text-left" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Update Data Users
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-users/update') ?>" method="POST" enctype="multipart/form-data" files="true">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="editId" name="id">
                            <label>NIK</label>
                            <div class="form-group">
                                <input id="editNIK" name="nik" type="number" placeholder="Masukkan NIK" class="form-control" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==16) return false;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama</label>
                            <div class="form-group">
                                <input id="editNama" name="nama" type="text" placeholder="Masukkan Nama" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Password</label>
                            <div class="form-group">
                                <input id="editPassword" name="password" type="password" placeholder="Masukkan Password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Role</label>
                            <div class="form-group">
                                <select name="role" id="editRole" class="selectize">
                                    <option value=""></option>
                                    <option value="mandor">Mandor</option>
                                    <option value="pelaksana">Pelaksana</option>
                                    <option value="tukang">Tukang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Foto User</label>
                            <div class="form-group">
                                <input id="editFoto" name="foto" type="file" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Pengawas</label>
                            <div class="form-group">
                                <select name="pengawas_id" id="editPengawas" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($pengawas as $row) : ?>
                                        <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama_pengawas']; ?>">
                                            <?= $row['nama_pengawas'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Jabatan</label>
                            <div class="form-group">
                                <select name="jabatan_id" id="editJabatan" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($jabatan as $row) : ?>
                                        <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama_jabatan']; ?>">
                                            <?= $row['nama_jabatan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Bidang</label>
                            <div class="form-group">
                                <select name="bidang_id" id="editBidang" class="selectize">
                                    <option value=""></option>
                                    <?php foreach ($bidang as $row) : ?>
                                        <option value="<?= $row['id'] ?>" data-nama="<?= $row['nama_bidang']; ?>">
                                            <?= $row['nama_bidang'] ?></option>
                                    <?php endforeach; ?>
                                </select>
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
    const lightbox = GLightbox({
        selector: '.glightbox'
    });

    $(function() {
        $('#addPengawas').selectize({
            placeholder: 'Pilih Pengawas',
            searchField: 'label',
            searchField: ["nama_pengawas"],
        });
        $('#addRole').selectize({
            placeholder: 'Pilih Role',
            searchField: 'label',
        });
        $('#addJabatan').selectize({
            placeholder: 'Pilih Jabatan',
            searchField: 'label',
        });
        $('#addBidang').selectize({
            placeholder: 'Pilih Bidang',
            searchField: 'label',
        });
        $('#addPengawas').selectize({
            placeholder: 'Pilih Pengawas',
            searchField: 'label',
            searchField: ["nama_pengawas"],
        });
        $('#editRole').selectize({
            placeholder: 'Pilih Role',
            searchField: 'label',
        });
        $('#editPengawas').selectize({
            placeholder: 'Pilih Pengawas',
            searchField: 'label',
            searchField: ["nama_pengawas"],
        });
        $('#editJabatan').selectize({
            placeholder: 'Pilih Jabatan',
            searchField: 'label',
        });
        $('#editBidang').selectize({
            placeholder: 'Pilih Bidang',
            searchField: 'label',
        });
    })


    $('body').on('click', '#btnEdit', function() {
        var this_id = $(this).data('id');
        // alert(this_id);
        $.ajax({
            type: "GET",
            url: "<?= base_url('mandor/kelola-users/edit'); ?>",
            data: {
                id: this_id,
            },
            success: function(response) {
                $('#modalUpdate').modal('show');
                var encoded_data = response.data;
                var decoded_data = JSON.parse(atob(encoded_data));
                console.log(decoded_data);
                $('#editId').val(decoded_data.users[0].id);
                $('#editNIK').val(decoded_data.users[0].nik);
                $('#editNama').val(decoded_data.users[0].nama);
                $('#editRole')[0].selectize.setValue(decoded_data.users[0].role);
                $('#editPengawas')[0].selectize.setValue(decoded_data.users[0].pengawas_id);
                $('#editJabatan')[0].selectize.setValue(decoded_data.users[0].jabatan_id);
                $('#editBidang')[0].selectize.setValue(decoded_data.users[0].bidang_id);
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
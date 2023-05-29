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
                                <a class="btn icon icon-left btn-warning" id="btnEdit" data-id="<?= $val->id ?>"><i data-feather="alert-triangle"></i> Update User</a>
                                <a class="btn icon icon-left btn-danger" id="btnDelete" data-id="<?= base_url('pemilik/users/delete/' . $val->id); ?>"><i data-feather="alert-circle"></i> Delete User</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--modal Create Users -->
<div class="modal fade text-left" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">
                    Create User
                </h4>
            </div>
            <form action="<?= base_url('pemilik/users/store') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <label>Username</label>
                    <div class="form-group">
                        <input id="username" name="username" type="text" placeholder="Username" class="form-control" />
                    </div>
                    <label for="password">Kata Sandi: </label>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Kata Sandi" class="form-control" required />
                    </div>
                    <label>Role User: </label>
                    <div class="form-group">
                        <input id="role" name="role" type="text" placeholder="Role User" class="form-control" value="admin" readonly />
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
                    Update Data User
                </h4>
            </div>
            <form action="<?= base_url('pemilik/users/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <label>Username</label>
                    <div class="form-group">
                        <input id="editUsername" name="username" type="text" placeholder="Username" class="form-control" />
                    </div>
                    <label for="password">Kata Sandi: </label>
                    <div class="form-group">
                        <input type="password" id="editPassword" name="password" placeholder="Masukkan Kata Sandi Baru" class="form-control" required />
                    </div>
                    <label>Role User: </label>
                    <div class="form-group">
                        <input id="editRole" name="role" type="text" placeholder="Role User" class="form-control" value="admin" readonly />
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
            url: "<?= base_url('pemilik/users/edit'); ?>",
            data: {
                id: this_id,
            },
            success: function(response) {
                $('#modalUpdate').modal('show');
                var encoded_data = response.data;
                var decoded_data = JSON.parse(atob(encoded_data));
                $('#editId').val(decoded_data.users.id);
                $('#editUsername').val(decoded_data.users.username);
                $('#editRole').val(decoded_data.users.role);
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
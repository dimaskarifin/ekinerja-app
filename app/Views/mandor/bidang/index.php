<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <a class="btn icon icon-left btn-primary" data-bs-target="#modalCreate" data-bs-toggle="modal"><i data-feather="edit"></i> Tambah Data Bidang</a>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NAMA</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    ?>
                    <?php foreach ($bidang as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_bidang']; ?></td>
                            <td>
                                <a class="btn icon btn-lg btn-warning" id="btnEdit" data-id="<?= $row['id'] ?>"><i class="bi bi-pencil-square"></i></a>
                                <a class="btn icon btn-lg btn-danger" id="btnDelete" data-id="<?= base_url('mandor/kelola-bidang/delete/' . $row['id']); ?>"><i class="bi bi-trash"></i></a>
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
                    Tambah Data Bidang
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-bidang/store') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <label>Nama Bidang</label>
                    <div class="form-group">
                        <input id="nama_bidang" name="nama_bidang" type="text" placeholder="Masukkan Nama Bidang" class="form-control" />
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
                    Update Data Bidang
                </h4>
            </div>
            <form action="<?= base_url('mandor/kelola-bidang/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <label>Nama Bidang</label>
                    <div class="form-group">
                        <input id="editBidang" name="nama_bidang" type="text" placeholder="Masukkan Nama Bidang" class="form-control" />
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
            url: "<?= base_url('mandor/kelola-bidang/edit'); ?>",
            data: {
                id: this_id,
            },
            success: function(response) {
                $('#modalUpdate').modal('show');
                var encoded_data = response.data;
                var decoded_data = JSON.parse(atob(encoded_data));
                $('#editId').val(decoded_data.bidang.id);
                $('#editBidang').val(decoded_data.bidang.nama_bidang);
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
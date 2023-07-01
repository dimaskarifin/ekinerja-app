<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="section">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Profile User</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profile-user/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="text-center mb-3">
                            <img src="<?= base_url('assets/uploads/' . $user['foto']); ?>" alt="foto" srcset="" class="w-50" />
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="foto" value="" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nik" value="<?= $user['nik'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="<?= $user['nama'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tempat_lahir" value="<?= $user['tempat_lahir'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_lahir" value="<?= $user['tanggal_lahir'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat" rows="3"><?= $user['alamat']; ?></textarea>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Perbarui Password</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profile-user/' . $user['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-warning">Perbarui Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection('main-content'); ?>

<?= $this->section('script'); ?>
<?= $this->include('layouts/message-alert'); ?>
<?= $this->endSection('script'); ?>
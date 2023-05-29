<script>
    $(document).ready(function() {
        <?php if (session()->has("success")) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session("success") ?>'
            })
        <?php } ?>

        <?php if (session()->has("warning")) { ?>
            Swal.fire({
                icon: 'warning',
                title: 'Gagal!',
                html: '<?= session("warning") ?>'
            })
        <?php } ?>
    });
</script>
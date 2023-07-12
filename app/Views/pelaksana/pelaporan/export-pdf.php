<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Proyek</title>
</head>
<style>
    .table,
    th,
    td {
        border: 1px solid;
        border-collapse: collapse;
    }

    .text-center {
        text-align: center;
    }

    .w-25 {
        width: 25%;
    }

    .w-50 {
        width: 50%;
    }

    .w-75 {
        width: 75%;
    }

    .w-100 {
        width: 100%;
    }

    .m-1 {
        margin: 1em;
    }

    .m-2 {
        margin: 2em;
    }

    .mt-2 {
        margin-top: 2em;
    }

    .mt-3 {
        margin-top: 3em;
    }

    .mt-4 {
        margin-top: 4em;
    }

    .mb-3 {
        margin-bottom: 3em;
    }

    .text-undeline {
        text-decoration: underline;
    }

    .row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 10px;
    }

    .col {
        flex: 1;
        padding: 10px;
    }

    .border {
        border: 1px solid;
        border-collapse: collapse;
    }

    .fs-5 {
        font-size: 15px;
    }

    .fw-bold {
        font-weight: bold;
    }
</style>

<body>
    <div class="container m-2">
        <h3 class="text-undeline text-center">Laporan Pekerjaan
            <?= $kategori ?>
        </h3>
        <p class="text-center mb-3">Hari / Tanggal :
            <?= $tanggal ?>
        </p>
        <?php if (!empty($user)) { ?>
            <p>NIK :
                <?= $user['nik'] ?><br>
                Nama:
                <?= $user['nama'] ?>
            </p>
        <?php } ?>

        <!-- table -->
        <table class="table w-100">
            <thead>
                <tr>
                    <th>No.</th>
                    <?php if (empty($user)) { ?>
                        <th>Nama</th>
                    <?php } ?>
                    <th>Uraian Kegiatan</th>
                    <th>Satuan</th>
                    <th>Rincian</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (count($kinerjas) > 0) {
                    foreach ($kinerjas as $kinerja) { ?>
                        <tr>
                            <td class="text-center">
                                <?= $no++ ?>
                            </td>
                            <?php if (empty($user)) { ?>
                                <td>
                                    <?= $kinerja['data']['nama'] ?>
                                </td>
                            <?php } ?>
                            <td>
                                <?= $kinerja['data']['uraian_kegiatan'] ?>
                            </td>
                            <td class="text-center">
                                <?= $kinerja['data']['target'] . ' ' . $kinerja['data']['satuan'] ?>
                            </td>
                            <td>
                                <?= implode('<br>', $kinerja['output']) ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- end table -->


        <table class="table text-center border-none w-100 mt-3" style="border: none;">
            <tr style="border: none;">
                <td style="border: none;">
                    <p class="fs-5 mb-3">Pengawas Lapangan</p>
                    <br>
                    <p class="mt-4">
                        <?= $mandor ?> <br> NIK.
                        <?= $nik_mandor ?>
                    </p> <!-- nama dan nik mandor -->
                </td>
                <td style="border: none;">
                    <p class="fs-5 mb-3">Kediri,
                        <?= $tanggal_sekarang ?> <br>
                        Pelaksana Lapangan
                    </p>
                    <br>
                    <p class="mt-3">
                        <span>Suryono</span> <br> NIK.
                        <span>3504050606790003</span>
                    </p> <!-- nama dan nik pelaksana -->
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
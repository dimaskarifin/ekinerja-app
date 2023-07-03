<?= $this->extend('layouts/index'); ?>

<?= $this->section('main-content'); ?>
<section class="row">
    <div class="col-12 col-lg-12">
        <div class="row">
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldPaper"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">
                                    TOTAL KEGIATAN
                                </h6>
                                <h6 class="font-extrabold mb-0">
                                    <?= $total_kegiatan ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon blue mb-2">
                                    <i class="iconly-boldPaper-Download"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">TOTAL PROYEK</h6>
                                <h6 class="font-extrabold mb-0">
                                    <?= $total_proyek ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon green mb-2">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">USERS</h6>
                                <h6 class="font-extrabold mb-0">
                                    <?= $total_user ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header">
                    <input type="month" class="form-control input-month">
                </div>
                <div class="card-body">
                    <canvas id="chartJs" class="h-100"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection('main-content'); ?>

<?= $this->section('script'); ?>
<script>
    let chart;
    let labels = [];
    let values = [];

    const plugin = {
        id: 'chartJs',
        beforeDraw: (chart, args, options) => {
            const {
                ctx
            } = chart;
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = options.color || '#99ffff';
            ctx.fillRect(0, 0, chart.width, chart.height);
            ctx.restore();
        }
    };

    $(document).ready(function() {
        <?php
        $old_value_month = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
        foreach ($chart as $item) { ?>
            labels.push('<?= $item['nama'] ?>');
            values.push(<?= $item['total_proyek'] ?>);
        <?php } ?>

        $(".input-month").val('<?= $old_value_month ?>');

        chartJs(labels, values);
    });

    $(".input-month").change(function(e) {
        e.preventDefault();

        let get_data = $(this).val();

        window.location.href = '<?= base_url('dashboard?tanggal=') ?>' + get_data;
    });

    function chartJs(labels, values) {
        const ctx = document.getElementById('chartJs').getContext('2d');

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Array of labels
                datasets: [{
                    label: 'Total pengerjaan proyek tukang',
                    data: values, // Array of data values
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                // plugins: {
                //     customCanvasBackgroundColor: {
                //         color: 'lightGreen',
                //     }
                // }
            },
            // plugins: [plugin],
        });
    }
</script>
<?= $this->endSection('script'); ?>
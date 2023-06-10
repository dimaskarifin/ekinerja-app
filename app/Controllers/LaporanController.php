<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EkinerjaModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\Request;
use DateInterval;
use DatePeriod;
use DateTime;
use Dompdf\Dompdf;

class LaporanController extends BaseController
{
    protected $ekinerja, $user;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);

        $this->ekinerja = new EkinerjaModel;
        $this->user = new UsersModel;
    }

    public function index()
    {
        $get_data = $this->request->getGet();

        if (!empty($get_data['tanggal'])) {
            $tanggal = $this->tanggalPerMinggu($get_data['tanggal']);
            $get_data['date_range']['start_date'] = "$tanggal[0]";
            $get_data['date_range']['end_date'] = "$tanggal[6]";
        }

        $data = [
            'title' => 'Laporan',
            'laporans' => $this->ekinerja->getLaporan($get_data),
            'users' => $this->user->where('deleted_at', null)->find(),
        ];

        return view('pelaporan/laporan/index', $data);
    }

    public function exportPdf()
    {
        $get_data = $this->request->getGet();
        $kategori = "";
        if ($get_data['kategori'] == 'date') {
            $kategori = "Harian";
        } else if($get_data['kategori'] == 'week') {
            $kategori = "Mingguan";
        } else if ($get_data['kategori'] == 'month') {
            $kategori = "Bulanan";
        }
        
        $tanggal_sekarang = $this->tanggalIndo(date('Y-m-d'));
        
        if ($get_data['kategori'] != 'week') {
            $tanggal = $this->tanggalIndo($get_data['tanggal']);
        } else {
            $tanggalPerMinggu = $this->tanggalPerMinggu($get_data['tanggal']);
            $get_data['date_range']['start_date'] = "$tanggalPerMinggu[0]";
            $get_data['date_range']['end_date'] = "$tanggalPerMinggu[6]";
            $tanggalMulai = $this->tanggalIndo($tanggalPerMinggu[0]);
            $tanggalSelesai = $this->tanggalIndo($tanggalPerMinggu[6]);
            $tanggal = "{$tanggalMulai} - {$tanggalSelesai}";
        }

        $dompdf = new Dompdf();

        $mandor = $this->user->where('role', 'mandor')->first();

        $data = [];
        $data['kinerjas'] = $this->ekinerja->getLaporan($get_data);
        $data['nik_mandor'] = $mandor['nik'];
        $data['mandor'] = $mandor['nama'];
        $data['kategori'] = $kategori;
        $data['tanggal'] = $tanggal;
        $data['tanggal_sekarang'] = $tanggal_sekarang;
        $data['user'] = $this->user->where('nik', $get_data['nik'])->first();

        $dompdf->loadHtml(view('pelaporan/laporan/export-pdf', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Laporan Kinerja $kategori - $tanggal.pdf");
    }

    private function tanggalIndo($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $explode = explode('-', $tanggal);

        if (count($explode) > 2) {
            return $explode[2] . ' ' . $bulan[(int) $explode[1]] . ' ' . $explode[0];
        } else {
            return $bulan[(int) $explode[1]] . ' ' . $explode[0];
        }
    }

    private function tanggalPerMinggu($tanggal)
    {   
        // Membuat objek DateTime dari input
        $dateTime = new DateTime($tanggal);

        // Mengatur objek DateTime ke hari Senin di minggu yang dipilih
        $dateTime->modify('this week')->modify('Monday');

        // Mendapatkan tanggal per minggu dengan rentang DatePeriod
        $dateInterval = new DateInterval('P1D');
        $dateRange = new DatePeriod($dateTime, $dateInterval, 6);

        // Membuat daftar tanggal per minggu
        $tanggalPerMinggu = [];
        foreach ($dateRange as $tanggal) {
            $tanggalPerMinggu[] = $tanggal->format('Y-m-d');
        }

        return $tanggalPerMinggu;
    }
}
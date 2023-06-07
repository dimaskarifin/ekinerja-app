<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EkinerjaModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\Request;
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
        $input = $this->request->getGet();

        $data = [
            'title' => 'Laporan',
            'laporans' => $this->ekinerja->getLaporan($input),
            'users' => $this->user->where('deleted_at', null)->find(),
        ];

        return view('pelaporan/laporan/index', $data);
    }

    public function exportPdf()
    {
        $get_data = $this->request->getGet();
        $kategori = $get_data['kategori'] == 'date' ? 'Harian' : 'Bulanan';
        $tanggal = $this->tanggalIndo($get_data['tanggal']);
        $tanggal_sekarang = $this->tanggalIndo(date('Y-m-d'));

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
        $bulan = array (
            1 =>   'Januari',
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
            return $explode[2] . ' ' . $bulan[ (int)$explode[1] ] . ' ' . $explode[0];
        } else {
            return $bulan[ (int)$explode[1] ] . ' ' . $explode[0];
        }
    }
}
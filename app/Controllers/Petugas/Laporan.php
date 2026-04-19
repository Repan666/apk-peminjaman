<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use Dompdf\Dompdf;

class Laporan extends BaseController
{

    protected $peminjamanModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
    }


    // ==========================
    // LAPORAN PEMINJAMAN
    // ==========================
    public function peminjaman()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    // Kalau ada filter tanggal → pakai procedure
    if ($tanggal_awal && $tanggal_akhir) {

        $query = $db->query("CALL laporan_peminjaman(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);

        $data['laporan'] = $query->getResult();

    } else {
        // fallback (biar tetap jalan kalau tidak filter)
        $data['laporan'] = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();
    }

    return view('petugas/laporan/peminjaman', $data);
}
    // ==========================
    // LAPORAN PENGEMBALIAN
    // ==========================
    public function pengembalian()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    if ($tanggal_awal && $tanggal_akhir) {

        $query = $db->query("CALL laporan_pengembalian(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);

        $data['laporan'] = $query->getResult();

    } else {
        // fallback
        $data['laporan'] = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.tanggal_dikembalikan,
                peminjaman.denda,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.status','selesai')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();
    }

    return view('petugas/laporan/pengembalian', $data);
}


public function peminjamanPdf()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    // =========================
    // AMBIL DATA (SAMA PERSIS KAYAK YANG VIEW)
    // =========================
    if ($tanggal_awal && $tanggal_akhir) {

        $query = $db->query("CALL laporan_peminjaman(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);

        $data['laporan'] = $query->getResultArray();

    } else {

        $data['laporan'] = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();
    }
    $data['dicetak_oleh'] = [
    'nama' => session()->get('nama'),
    'role' => session()->get('role')
    ];

    // =========================
    // LOAD VIEW KHUSUS PDF
    // =========================
    $html = view('petugas/laporan/peminjaman_pdf', $data);

    // =========================
    // DOMPDF
    // =========================
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // 🔥 PENTING: BIAR GA KE-REPLACE
    $filename = 'laporan_peminjaman_' . date('Ymd_His') . '.pdf';

    $dompdf->stream($filename, ['Attachment' => true]);
}
public function pengembalianPdf()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    // =========================
    // AMBIL DATA
    // =========================
    if ($tanggal_awal && $tanggal_akhir) {

        $query = $db->query("CALL laporan_pengembalian(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);

        $data['laporan'] = $query->getResultArray();

    } else {

        $data['laporan'] = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.tanggal_dikembalikan,
                peminjaman.denda,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.status','selesai')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();
    }

    // =========================
    // INFO CETAK (STRING BIAR AMAN)
    // =========================
    $data['dicetak_oleh'] = session()->get('nama') . ' (' . session()->get('role') . ')';

    // =========================
    // LOAD VIEW PDF
    // =========================
    $html = view('petugas/laporan/pengembalian_pdf', $data);

    // =========================
    // DOMPDF
    // =========================
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // 🔥 biar ga ke replace
    $filename = 'laporan_pengembalian_' . date('Ymd_His') . '.pdf';

    $dompdf->stream($filename, ['Attachment' => true]);
}
// ==========================
// EXPORT EXCEL PEMINJAMAN
// ==========================
public function peminjamanExcel()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    if ($tanggal_awal && $tanggal_akhir) {
        $query = $db->query("CALL laporan_peminjaman(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);
        $laporan = $query->getResultArray(); // 🔥 PAKSA ARRAY
    } else {
        $laporan = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->orderBy('peminjaman.id','DESC')
            ->findAll();
    }

    ob_clean();

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_peminjaman.xls");

    echo "<table border='1'>";
    echo "<tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Alat</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
          </tr>";

    $no = 1;
    foreach($laporan as $r){
        echo "<tr>
                <td>{$no}</td>
                <td>{$r['nama_peminjam']}</td>
                <td>{$r['nama_alat']}</td>
                <td>{$r['tanggal_pinjam']}</td>
                <td>{$r['tanggal_kembali']}</td>
                <td>{$r['status']}</td>
              </tr>";
        $no++;
    }

    echo "</table>";
}
// ==========================
// EXPORT EXCEL PENGEMBALIAN
// ==========================
public function exportPengembalianExcel()
{
    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    $db = \Config\Database::connect();

    if ($tanggal_awal && $tanggal_akhir) {
        $query = $db->query("CALL laporan_pengembalian(?, ?)", [
            $tanggal_awal,
            $tanggal_akhir
        ]);

        // 🔥 PAKSA ARRAY (BIAR KONSISTEN)
        $data = $query->getResultArray();

    } else {
        $data = $this->peminjamanModel
            ->select('
                peminjaman.id,
                users.nama AS nama_peminjam,
                alat.nama_alat,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                peminjaman.tanggal_dikembalikan,
                peminjaman.denda,
                peminjaman.status
            ')
            ->join('users','users.id = peminjaman.user_id')
            ->join('alat','alat.id = peminjaman.alat_id')
            ->where('peminjaman.status','selesai')
            ->orderBy('peminjaman.id','DESC')
            ->findAll(); // ini sudah array
    }

    // 🔥 BERSIHKAN OUTPUT BUFFER
    ob_clean();

    // HEADER EXCEL
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_pengembalian.xls");

    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Nama Peminjam</th>
            <th>Nama Alat</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Tanggal Dikembalikan</th>
            <th>Denda</th>
            <th>Status</th>
          </tr>";

    foreach ($data as $r) {
        echo "<tr>
                <td>{$r['id']}</td>
                <td>{$r['nama_peminjam']}</td>
                <td>{$r['nama_alat']}</td>
                <td>{$r['tanggal_pinjam']}</td>
                <td>{$r['tanggal_kembali']}</td>
                <td>{$r['tanggal_dikembalikan']}</td>
                <td>{$r['denda']}</td>
                <td>{$r['status']}</td>
              </tr>";
    }

    echo "</table>";
}

}
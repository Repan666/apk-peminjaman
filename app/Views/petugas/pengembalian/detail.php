<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('petugas/pengembalian') ?>" class="text-decoration-none text-muted small fw-bold">
        <i class="bi bi-arrow-left me-1"></i> KEMBALI KE DAFTAR
    </a>
    <h2 class="fw-bold text-slate-900 mt-2">Validasi Akhir Pengembalian</h2>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-clipboard-check me-2 text-emerald"></i>Data Pemeriksaan</h5>
            
            <div class="row mb-4">
                <div class="col-6">
                    <label class="text-muted small fw-bold d-block uppercase">Peminjam</label>
                    <span class="fw-bold text-dark fs-5"><?= $peminjaman['nama_user'] ?></span>
                </div>
                <div class="col-6 text-end">
                    <label class="text-muted small fw-bold d-block uppercase">Alat</label>
                    <span class="fw-bold text-emerald"><?= $peminjaman['nama_alat'] ?></span>
                    <div class="small text-muted"><?= $peminjaman['kode_alat'] ?></div>
                </div>
            </div>

            <div class="bg-light rounded-4 p-4 mb-4">
                <div class="row text-center">
                    <div class="col-md-5">
                        <label class="text-muted small d-block mb-1">Harus Kembali</label>
                        <div class="fw-bold"><?= date('d M Y', strtotime($peminjaman['tanggal_kembali'])) ?></div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-right fs-4 text-muted d-none d-md-block"></i>
                    </div>
                    <div class="col-md-5">
                        <label class="text-muted small d-block mb-1">Dikembalikan</label>
                        <div class="fw-bold text-emerald"><?= date('d M Y', strtotime($peminjaman['tanggal_dikembalikan'])) ?></div>
                    </div>
                </div>
            </div>

            <div class="card border-dashed border-2 rounded-4 p-3 <?= ($selisih > 0) ? 'border-danger bg-danger bg-opacity-10' : 'border-success bg-success bg-opacity-10' ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1 <?= ($selisih > 0) ? 'text-danger' : 'text-success' ?>">
                            <?= ($selisih > 0) ? 'Terlambat ' . $selisih . ' Hari' : 'Kembali Tepat Waktu' ?>
                        </h6>
                        <small class="text-muted">Tarif Denda: Rp <?= number_format($tarif, 0, ',', '.') ?> / Hari</small>
                    </div>
                    <div class="text-end">
                        <label class="small d-block text-muted">Total Denda</label>
                        <h4 class="fw-bold mb-0 <?= ($selisih > 0) ? 'text-danger' : 'text-success' ?>">
                            Rp <?= number_format($denda, 0, ',', '.') ?>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <form action="<?= base_url('petugas/pengembalian/verifikasi/'.$peminjaman['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-emerald w-100 py-3 rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-shield-check me-2"></i> SELESAIKAN & UPDATE STOK (+1)
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 bg-slate-900 text-white p-4">
            <h6 class="fw-bold text-emerald mb-3 small uppercase">SOP Verifikasi Pengembalian</h6>
            <div class="small opacity-75">
                <p class="mb-3">Sebelum menyelesaikan transaksi ini, petugas wajib:</p>
                <ol class="ps-3 mb-0">
                    <li class="mb-2">Mengecek kelengkapan fisik alat sesuai kode <b><?= $peminjaman['kode_alat'] ?></b>.</li>
                    <li class="mb-2">Memastikan tidak ada kerusakan baru pada alat.</li>
                    <li class="mb-2">Jika ada denda sebesar <b>Rp <?= number_format($denda, 0, ',', '.') ?></b>, pastikan peminjam sudah melunasi secara tunai/prosedur sekolah.</li>
                    <li class="mb-0">Setelah tombol diklik, stok alat akan otomatis bertambah kembali ke sistem.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-slate-900 { background-color: #0F172A; }
    .text-emerald { color: #10B981 !important; }
    .btn-emerald { background-color: #10B981; border: none; }
    .btn-emerald:hover { background-color: #059669; transform: translateY(-2px); transition: 0.3s; }
    .border-dashed { border-style: dashed !important; }
</style>

<?= $this->endSection() ?>
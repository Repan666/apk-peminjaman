<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/peminjaman" class="text-decoration-none small fw-bold text-emerald">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h2 class="fw-bold text-slate-900 mt-2">Tambah Peminjaman Baru</h2>
    <p class="text-muted small">Input data peminjaman manual (layanan offline/langsung).</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="/admin/peminjaman/store" method="post">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Mahasiswa / Peminjam</label>
                                <select name="user_id" class="form-select border-0 bg-light rounded-3" required>
                                    <option value="" selected disabled>Pilih User...</option>
                                    <?php foreach($users as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= $u['nama'] ?> (<?= $u['role'] ?>)</option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Alat Praktikum</label>
                                <select name="alat_id" class="form-select border-0 bg-light rounded-3" required>
                                    <option value="" selected disabled>Pilih Alat...</option>
                                    <?php foreach($alat as $a): ?>
                                        <option value="<?= $a['id'] ?>"><?= $a['nama_alat'] ?> - Stok: <?= $a['stok'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Set Status Awal</label>
                                <select name="status" class="form-select border-0 bg-light rounded-3">
                                    <option value="pending">Pending (Menunggu)</option>
                                    <option value="dipinjam">Langsung Dipinjam (Aktif)</option>
                                </select>
                                <div class="form-text" style="font-size: 0.7rem;">Pilih 'Langsung Dipinjam' jika alat sudah diserahkan.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tgl_pinjam" 
                                       class="form-control border-0 bg-light rounded-3" 
                                       value="<?= date('Y-m-d') ?>" 
                                       onchange="updateTglKembali()" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Rencana Kembali</label>
                                <input type="date" name="tanggal_kembali" id="tgl_kembali" 
                                       class="form-control border-0 bg-light rounded-3" 
                                       min="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Keterangan / Keperluan</label>
                                <textarea name="keterangan" class="form-control border-0 bg-light rounded-3" rows="3" placeholder="Contoh: Praktikum Jaringan Dasar"></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 text-faded">

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light px-4 rounded-pill fw-bold">Reset</button>
                        <button type="submit" class="btn btn-emerald px-5 rounded-pill fw-bold shadow-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="alert alert-info border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Tips Admin</h6>
            <p class="small mb-0">Pastikan stok alat tersedia sebelum melakukan input manual. Untuk peminjaman rutin, disarankan mereka mengajukan sendiri via akun masing-masing agar terekam dalam log pengajuan.</p>
        </div>
    </div>
</div>

<script>
    // Script validasi tanggal yang sama agar konsisten
    function updateTglKembali() {
        const tglPinjam = document.getElementById('tgl_pinjam').value;
        const inputKembali = document.getElementById('tgl_kembali');
        inputKembali.min = tglPinjam;
        if (inputKembali.value && inputKembali.value < tglPinjam) {
            inputKembali.value = tglPinjam;
        }
    }
</script>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .text-emerald { color: #10b981 !important; }
    .bg-light { background-color: #f8fafc !important; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981 !important;
    }
</style>

<?= $this->endSection() ?>
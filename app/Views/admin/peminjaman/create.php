<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/peminjaman" class="text-decoration-none small fw-bold text-emerald">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h2 class="fw-bold text-slate-900 mt-2">Tambah Peminjaman Baru</h2>
</div>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
        <i class="bi bi-x-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="/admin/peminjaman/store" method="post" id="formPeminjaman">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Peminjam</label>
                                <select name="user_id" id="user_select" class="form-select border-0 bg-light rounded-3" required onchange="checkAlatStatus()">
                                    <option value="" selected disabled>Pilih User...</option>
                                    <?php foreach($users as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= $u['nama'] ?> (<?= $u['role'] ?>)</option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Alat Praktikum</label>
                                <select name="alat_id" id="alat_select" class="form-select border-0 bg-light rounded-3" required onchange="checkAlatStatus()">
                                    <option value="" selected disabled>Pilih Alat...</option>
                                    <?php foreach($alat as $a): ?>
                                        <option value="<?= $a['id'] ?>" 
                                                data-stok="<?= $a['stok'] ?>" 
                                                data-kondisi="<?= strtolower(str_replace(' ', '_', $a['kondisi'])) ?>">
                                            <?= $a['nama_alat'] ?> (Stok: <?= $a['stok'] ?> | Kondisi: <?= $a['kondisi'] ?>)
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <div id="alat_feedback" class="mt-1 small fw-bold"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Set Status Awal</label>
                                <select name="status" class="form-select border-0 bg-light rounded-3">
                                    <option value="pending">Pending (Menunggu)</option>
                                    <option value="dipinjam">Langsung Dipinjam (Aktif)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tgl_pinjam" class="form-control border-0 bg-light rounded-3" value="<?= date('Y-m-d') ?>" onchange="updateTglKembali()" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Rencana Kembali</label>
                                <input type="date" name="tanggal_kembali" id="tgl_kembali" class="form-control border-0 bg-light rounded-3" min="<?= date('Y-m-d') ?>" required>
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
                        <button type="submit" id="btnSubmit" class="btn btn-emerald px-5 rounded-pill fw-bold shadow-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="alert alert-info border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Tips Admin</h6>
            <p class="small mb-0">Sistem akan secara otomatis memblokir tombol simpan jika alat rusak, stok habis, atau user tersebut sudah memiliki pinjaman aktif.</p>
        </div>
    </div>
</div>

<script>
    // Data peminjaman aktif dari controller
    const listPeminjamanAktif = <?= json_encode($peminjaman_aktif) ?>;

    function checkAlatStatus() {
        const selectAlat = document.getElementById('alat_select');
        const selectUser = document.getElementById('user_select');
        const feedback = document.getElementById('alat_feedback');
        const btnSubmit = document.getElementById('btnSubmit');
        
        const selectedOption = selectAlat.options[selectAlat.selectedIndex];
        const userId = selectUser.value;
        const alatId = selectAlat.value;
        
        const stok = parseInt(selectedOption.getAttribute('data-stok'));
        const kondisi = selectedOption.getAttribute('data-kondisi');

        // Cek apakah user sudah punya pinjaman aktif untuk alat ini
        const isAktif = listPeminjamanAktif.find(p => p.user_id == userId && p.alat_id == alatId);

        feedback.innerHTML = ''; 
        btnSubmit.disabled = false;

        if (kondisi === 'rusak_berat') {
            feedback.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle-fill"></i> Alat rusak berat!</span>';
            btnSubmit.disabled = true;
        } else if (stok <= 0) {
            feedback.innerHTML = '<span class="text-warning"><i class="bi bi-exclamation-triangle-fill"></i> Stok habis!</span>';
            btnSubmit.disabled = true;
        } else if (userId && isAktif) {
            feedback.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-octagon-fill"></i> User sudah meminjam alat ini!</span>';
            btnSubmit.disabled = true;
        } else if (userId) {
            feedback.innerHTML = '<span class="text-emerald"><i class="bi bi-check-circle-fill"></i> Alat siap dipinjam</span>';
        }
    }

    function updateTglKembali() {
        const tglPinjam = document.getElementById('tgl_pinjam').value;
        const inputKembali = document.getElementById('tgl_kembali');
        inputKembali.min = tglPinjam;
        if (inputKembali.value && inputKembali.value < tglPinjam) inputKembali.value = tglPinjam;
    }
</script>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .btn-emerald:disabled { background-color: #cbd5e1; cursor: not-allowed; }
    .text-emerald { color: #10b981 !important; }
    .bg-light { background-color: #f8fafc !important; }
</style>

<?= $this->endSection() ?>
<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/pengembalian" class="text-decoration-none small fw-bold text-emerald">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h2 class="fw-bold text-slate-900 mt-2">Pengembalian Secara Manual</h2>
    <p class="text-muted small">Input pengembalian alat secara manual jika peminjam tidak bisa mengajukan sendiri.</p>
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
                <form action="<?= base_url('admin/pengembalian/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pilih Peminjam</label>
                        <select id="userSelect" class="form-select border-0 bg-light rounded-3" required>
                            <option value="" selected disabled>-- Pilih Peminjam --</option>
                            <?php foreach($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= $u['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Alat yang Dipinjam</label>
                        <select name="peminjaman_id" id="pinjamanSelect" class="form-select border-0 bg-light rounded-3" required disabled>
                            <option value="">-- Pilih peminjam terlebih dahulu --</option>
                        </select>
                        <div class="form-text small">Daftar alat yang sedang dipinjam oleh user tersebut.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light px-4 rounded-pill fw-bold">Reset</button>
                        <button type="submit" class="btn btn-emerald px-5 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan Pengembalian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="alert alert-info border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Informasi</h6>
            <p class="small mb-0">Pastikan alat yang dikembalikan sudah diperiksa kondisinya. Sistem akan mengubah status pinjaman menjadi <b>Menunggu Verifikasi</b> atau <b>Selesai</b> sesuai alur aplikasi.</p>
        </div>
    </div>
</div>

<script>
document.getElementById('userSelect').addEventListener('change', function(){
    let userId = this.value;
    let pinjamanSelect = document.getElementById('pinjamanSelect');

    pinjamanSelect.innerHTML = '<option>Memuat data...</option>';
    pinjamanSelect.disabled = true;

    if(userId){
        fetch("<?= base_url('admin/pengembalian/getPinjamanByUser') ?>/" + userId)
        .then(res => res.json())
        .then(data => {
            pinjamanSelect.innerHTML = '';
            
            if(data.length === 0){
                pinjamanSelect.innerHTML = '<option value="">Tidak ada pinjaman aktif</option>';
            } else {
                pinjamanSelect.disabled = false;
                data.forEach(item => {
                    let option = document.createElement('option');
                    option.value = item.id;
                    option.text = item.nama_alat + ' (Jatuh tempo: ' + item.tanggal_kembali + ')';
                    pinjamanSelect.appendChild(option);
                });
            }
        })
        .catch(err => {
            pinjamanSelect.innerHTML = '<option value="">Gagal memuat data</option>';
        });
    } else {
        pinjamanSelect.innerHTML = '<option value="">-- Pilih dulu peminjam --</option>';
    }
});
</script>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .text-emerald { color: #10b981 !important; }
    .bg-light { background-color: #f8fafc !important; }
    .form-select:focus, .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981 !important;
    }
</style>

<?= $this->endSection() ?>
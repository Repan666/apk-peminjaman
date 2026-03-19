<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold text-slate-900 mb-1">Pengaturan Sistem</h2>
    <p class="text-muted small">Konfigurasi parameter global untuk operasional APKLOAN.</p>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4 animate__animated animate__fadeInDown">
        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-check-all text-success"></i>
        </div>
        <div class="fw-medium text-success"><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-emerald bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-cash-stack text-emerald"></i>
                    </div>
                    <h6 class="fw-bold text-slate-900 mb-0">Kebijakan Denda</h6>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('admin/settings/update') ?>">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-slate-900 small">Biaya Denda Keterlambatan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 fw-bold text-muted">Rp</span>
                            <input type="number" name="denda" 
                                   class="form-control border-start-0 py-2 rounded-end-3 fw-bold" 
                                   value="<?= $denda ?>" required 
                                   placeholder="Contoh: 5000">
                        </div>
                        <div class="form-text mt-2 small text-muted">
                            <i class="bi bi-info-circle me-1"></i> Nominal denda ini akan dihitung otomatis **per hari** keterlambatan pengembalian alat.
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-4 border-start border-4 border-emerald">
                        <small class="text-muted d-block mb-1">Pratinjau Saat Ini:</small>
                        <h4 class="fw-bold text-slate-900 mb-0">Rp <?= number_format($denda, 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">/ hari</span></h4>
                    </div>

                    <button type="submit" class="btn btn-emerald w-100 py-2 rounded-3 text-white fw-bold shadow-sm">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 bg-slate-900 rounded-4 p-4 text-white h-100 shadow-sm">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightbulb text-warning me-2"></i>Tips Pengaturan</h6>
            <p class="small opacity-75">Perubahan nominal denda akan berdampak pada:</p>
            <ul class="list-unstyled small opacity-75">
                <li class="mb-2"><i class="bi bi-dot me-1"></i> Kalkulasi denda pada transaksi pengembalian baru.</li>
                <li class="mb-2"><i class="bi bi-dot me-1"></i> Laporan keuangan denda di dashboard.</li>
                <li><i class="bi bi-dot me-1"></i> Informasi denda pada struk/bukti pinjam.</li>
            </ul>
            <hr class="opacity-25">
            <p class="small mb-0 opacity-50 italic">Pastikan sudah mendiskusikan perubahan biaya dengan manajemen sebelum memperbarui data.</p>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; border: none; }
    .btn-emerald:hover { background-color: #059669; transform: translateY(-1px); }
    .bg-slate-900 { background-color: #0f172a !important; }
</style>

<?= $this->endSection() ?>
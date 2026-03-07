<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Peminjam' ?> | APKLOAN</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --slate-900: #0F172A;
            --emerald-500: #10B981;
            --ghost-white: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--ghost-white);
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: var(--slate-900);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 1.5rem;
        }

        .nav-link {
            color: #CBD5E1 !important;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
            opacity: 0.7;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white !important;
        }

        .nav-link.active {
            background: var(--emerald-500) !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .nav-link.active i { opacity: 1; }

        .menu-label {
            color: #64748B;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 25px;
            margin-bottom: 10px;
            padding-left: 15px;
            display: block;
        }

        .main-wrapper {
            margin-left: 280px;
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .content-padding { padding: 40px; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="d-flex align-items-center mb-4 px-2">
            <i class="bi bi-stack text-success fs-3 me-2"></i>
            <span class="fs-4 fw-bold text-white">APK<span class="text-success">LOAN</span></span>
        </div>
        
        <span class="menu-label">MENU UTAMA</span>
        <a class="nav-link <?= url_is('peminjam/dashboard*') ? 'active' : '' ?>" href="<?= base_url('peminjam/dashboard') ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        
        <a class="nav-link <?= url_is('peminjam/alat*') ? 'active' : '' ?>" href="<?= base_url('peminjam/alat') ?>">
            <i class="bi bi-tools"></i> Daftar Alat
        </a>
        
        <span class="menu-label">AKTIVITAS PINJAM</span>
        <a class="nav-link <?= url_is('peminjam/pinjaman*') ? 'active' : '' ?>" href="<?= base_url('peminjam/pinjaman') ?>">
            <i class="bi bi-arrow-repeat text-warning"></i> Pinjaman Aktif
        </a>
        <a class="nav-link <?= url_is('peminjam/riwayat*') ? 'active' : '' ?>" href="<?= base_url('peminjam/riwayat') ?>">
            <i class="bi bi-clock-history text-info"></i> Riwayat Pinjam
        </a>
    </div>

    <div class="main-wrapper">
        <header class="top-navbar">
            <div>
                <span class="text-muted">Halo Peminjam,</span> 
                <span class="fw-bold text-dark"><?= session()->get('nama') ?></span>
            </div>
            <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm px-4 rounded-pill">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </a>
        </header>

        <div class="content-padding">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
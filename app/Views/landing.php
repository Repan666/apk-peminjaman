<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APKLOAN | Sistem Manajemen Peminjaman Alat</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --slate-900: #0F172A;
            --slate-800: #1E293B;
            --slate-600: #475569;
            --emerald-500: #10B981;
            --emerald-600: #059669;
            --ghost-white: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--ghost-white);
            color: var(--slate-800);
            overflow-x: hidden;
        }

        /* --- Glassmorphism Navbar --- */
        .navbar {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: rgba(15, 23, 42, 0.8) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -1px;
        }

        /* --- Premium Hero Section --- */
        .hero-section {
            position: relative;
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
            padding: 180px 0 140px 0;
            overflow: hidden;
        }

        /* Dekorasi Geometris di Belakang Hero */
        .hero-section::before {
            content: "";
            position: absolute;
            top: -10%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(16, 185, 129, 0.05);
            border-radius: 50%;
            filter: blur(80px);
        }

        .hero-title {
            font-weight: 800;
            line-height: 1.2;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* --- Buttons Upgrade --- */
        .btn-emerald {
            background: var(--emerald-500);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
        }

        .btn-emerald:hover {
            background: var(--emerald-600);
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid rgba(255,255,255,0.2);
            color: white;
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
            color: white;
        }

        /* --- Feature Cards Upgrade --- */
        .feature-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 24px;
            padding: 40px;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.08);
            border-color: var(--emerald-500);
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            color: var(--emerald-500);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            font-size: 2rem;
            margin-bottom: 25px;
            transition: 0.3s;
        }

        .feature-card:hover .icon-wrapper {
            background: var(--emerald-500);
            color: white;
            transform: scale(1.1) rotate(-5deg);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section { padding: 120px 0 80px 0; text-align: center; }
            .hero-title { font-size: 2.5rem; }
            .d-flex.gap-3 { justify-content: center; }
        }
        /* Styling container logo supaya presisi */
.logo-container {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

/* Biar logo ada efek sedikit glow kalau hover, biar makin premium */
.logo-container:hover {
    transform: scale(1.05);
}

/* Sesuaikan font navbar biar selaras sama brand */
.navbar-brand {
    font-size: 1.4rem;
    font-weight: 800;
}
.navbar {
    padding-top: 0.5rem !important;    /* Atur padding atas */
    padding-bottom: 0.5rem !important; /* Atur padding bawah */
}

/* Memastikan container logo tidak mendorong terlalu jauh */
.logo-container {
    display: flex;
    align-items: center;
    justify-content: center;
}
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
    <div class="logo-container me-2">
        <img src="<?= base_url('assets/img/logo projek ukk.png') ?>" 
             alt="Logo APKLOAN" 
             class="img-fluid"
             style="height: 90px; width: auto; object-fit: contain;">
    </div>
</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="bi bi-list fs-1"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link px-3" href="#roles">Hak Akses</a></li>
                <li class="nav-item ms-lg-4">
                    <a class="btn btn-emerald px-4" href="<?= base_url('login'); ?>">
                        Portal Login <i class="bi bi-arrow-right-short"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <section class="hero-section">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-emerald-500 bg-opacity-10 text-success px-3 py-2 rounded-pill mb-3 fw-bold">
                       
                    </span>
                    <h1 class="hero-title display-3 mb-4">Efisiensi Peminjaman Alat Dalam Genggaman.</h1>
                    <p class="text-light opacity-75 fs-5 mb-5 pe-lg-5">
                        Pantau, pinjam, dan kelola inventaris alat dengan sistem otomatisasi tercanggih. Dibangun untuk transparansi dan akurasi data.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="<?= base_url('login'); ?>" class="btn btn-emerald btn-lg px-5">Mulai Sekarang</a>
                        <a href="#" class="btn btn-outline-custom btn-lg">Dokumentasi</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="position-relative">
                        <div class="p-5 bg-white bg-opacity-5 rounded-circle border border-white border-opacity-10 text-center animate-bounce">
                            <i class="bi bi-shield-check display-1 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="roles" class="py-5" style="margin-top: -50px;">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="icon-wrapper">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Administrator</h4>
                        <p class="text-slate-600 leading-relaxed">
                            Otoritas tertinggi untuk manajemen user, kategori alat, dan kendali sistem backend secara menyeluruh.
                        </p>
                        <hr class="my-4 opacity-50">
                        <div class="d-flex align-items-center text-success fw-bold small">
                            FULL ACCESS CONTROL <i class="bi bi-check-circle-fill ms-2"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="icon-wrapper">
                            <i class="bi bi-clipboard2-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Staff Petugas</h4>
                        <p class="text-slate-600 leading-relaxed">
                            Bertanggung jawab atas verifikasi peminjaman, pengecekan kondisi alat, dan approval transaksi harian.
                        </p>
                        <hr class="my-4 opacity-50">
                        <div class="d-flex align-items-center text-success fw-bold small">
                            OPERATIONAL ACCESS <i class="bi bi-check-circle-fill ms-2"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="icon-wrapper">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Peminjam</h4>
                        <p class="text-slate-600 leading-relaxed">
                            Kemudahan akses untuk melihat katalog alat, melakukan booking secara online, dan riwayat peminjaman.
                        </p>
                        <hr class="my-4 opacity-50">
                        <div class="d-flex align-items-center text-success fw-bold small">
                            USER REQUEST ACCESS <i class="bi bi-check-circle-fill ms-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-white">
        <div class="container text-center">
            <div class="mb-4">
                <a class="navbar-brand text-dark" href="#">
                    <i class="bi bi-stack text-success"></i> APK<span class="text-success">LOAN</span>
                </a>
            </div>
            <p class="text-muted small">Dibuat untuk Uji Kompetensi Keahlian (UKK) © <?= date('Y'); ?>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Loaan.Q System</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --emerald-500: #10B981;
            --emerald-600: #059669;
            --slate-900: #0F172A;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 100% 100%, #1e293b 0%, #0f172a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            border-color: var(--emerald-500);
            background: #fff;
        }

        .input-group-text {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 14px 0 0 14px;
            color: #94A3B8;
        }

        .toggle-password {
            border-radius: 0 14px 14px 0 !important;
            cursor: pointer;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-left: none;
        }

        .btn-login {
            background: var(--emerald-500);
            color: white;
            border-radius: 14px;
            padding: 12px;
            font-weight: 700;
            width: 100%;
            border: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: var(--emerald-600);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-4">
            <img src="<?= base_url('assets/img/Logo Projek UKK.png') ?>" alt="Logo" style="height: 70px;" class="mb-3">
            <h4 class="fw-bold text-slate-900">Selamat Datang</h4>
            <p class="text-muted small">Login untuk akses sistem inventaris</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 rounded-4 p-2 text-center small mb-3">
                <i class="bi bi-x-circle me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('/login/process'); ?>">
            <?= csrf_field(); ?>
            
            <div class="mb-3">
                <label class="small fw-bold text-muted">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="small fw-bold text-muted">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login">Masuk Sistem</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
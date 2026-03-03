<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | APKLOAN System</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --slate-900: #0F172A;
            --emerald-500: #10B981;
            --bg-ghost: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 0% 0%, #1e293b 0%, #0f172a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 1);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--slate-900);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--slate-900);
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            background-color: #F1F5F9;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            border-color: var(--emerald-500);
            background-color: #fff;
        }

        .btn-login {
            background: var(--emerald-500);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .input-group-text {
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 12px 0 0 12px;
        }
        
        .form-control {
            border-radius: 0 12px 12px 0 !important;
        }
    </style>
</head>
<body>

    <div class="container p-3">
        <div class="login-card mx-auto">
            <div class="text-center mb-4">
                <a href="<?= base_url(); ?>" class="brand-logo">
                    <i class="bi bi-stack text-success"></i> APK<span class="text-success">LOAN</span>
                </a>
                <p class="text-muted mt-2">Silakan login untuk mengakses sistem</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 d-flex align-items-center mb-4" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('/login/process'); ?>">
                <?= csrf_field(); ?> <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    Masuk Sekarang <i class="bi bi-arrow-right-short ms-1"></i>
                </button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">Masalah login? Hubungi <a href="#" class="text-decoration-none text-success fw-bold">Admin IT</a></small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
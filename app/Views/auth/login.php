<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Login') ?> - Suro Fragrance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body{
            background:linear-gradient(180deg,#f8f8f8 0%,#efefef 100%);
            font-family:'Helvetica Neue', sans-serif;
        }

        .login-container{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:30px 15px;
        }

        .login-card{
            width:100%;
            max-width:440px;
            background:#fff;
            padding:38px;
            border-radius:18px;
            box-shadow:0 24px 50px rgba(0,0,0,.08);
        }

        .logo{
            text-align:center;
            font-weight:700;
            letter-spacing:2px;
            margin-bottom:8px;
        }

        .subtitle{
            color:#777;
            font-size:14px;
            text-align:center;
            margin-bottom:24px;
        }

        .mode-switch{
            display:grid;
            grid-template-columns:repeat(2, 1fr);
            gap:10px;
            margin-bottom:22px;
        }

        .mode-switch a{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:10px 14px;
            border-radius:12px;
            text-decoration:none;
            border:1px solid #ddd;
            color:#111;
            font-weight:600;
            transition:.2s ease;
        }

        .mode-switch a.active{
            background:#111;
            color:#fff;
            border-color:#111;
        }

        .mode-switch a:hover{
            transform:translateY(-1px);
        }

        .form-control{
            border-radius:10px;
            padding:12px;
        }

        .btn-lux{
            background:#111;
            color:#fff;
            border:none;
            width:100%;
            padding:11px;
            border-radius:10px;
            font-weight:600;
        }

        .btn-lux:hover{
            background:#c6a55c;
            color:#000;
        }

        .error,
        .message{
            font-size:14px;
            margin-bottom:12px;
        }

        .error{
            color:#d33;
        }

        .message{
            color:#198754;
        }

        .auth-link{
            margin-top:18px;
            font-size:14px;
            color:#777;
            text-align:center;
        }

        .auth-link a{
            color:#000;
            font-weight:600;
            text-decoration:none;
        }

        .auth-link a:hover{
            color:#c6a55c;
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">
        <div class="logo">SURO FRAGRANCE</div>
        <div class="subtitle"><?= esc($subtitle ?? 'Masuk ke akun Anda') ?></div>

        <div class="mode-switch">
            <a href="/login/customer" class="<?= ($roleMode ?? 'customer') === 'customer' ? 'active' : '' ?>">
                <i class="bi bi-bag"></i> Pelanggan
            </a>
            <a href="/login/admin" class="<?= ($roleMode ?? 'customer') === 'admin' ? 'active' : '' ?>">
                <i class="bi bi-shield-lock"></i> Admin
            </a>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="message">
                <?= esc(session()->getFlashdata('message')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('sukses')): ?>
            <div class="message">
                <?= esc(session()->getFlashdata('sukses')) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= esc($formAction ?? '/login/customer') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?= esc(old('email')) ?>" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-lux">
                <?= ($roleMode ?? 'customer') === 'admin' ? 'Login Admin' : 'Login Pelanggan' ?>
            </button>
        </form>

        <?php if (($roleMode ?? 'customer') === 'customer'): ?>
            <div class="auth-link">
                Belum punya akun? <a href="/register">Daftar akun</a>
            </div>
        <?php else: ?>
            <?php if (empty($adminAvailable ?? true)): ?>
                <div class="auth-link">
                    Belum ada admin? <a href="/setup-admin">Buat admin pertama</a>
                </div>
            <?php else: ?>
                <div class="auth-link">
                    Jika belum punya akses admin, hubungi pemilik toko.
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

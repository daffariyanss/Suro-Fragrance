<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Daftar Akun') ?> - Suro Fragrance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f8f8f8;
            font-family:'Helvetica Neue', sans-serif;
        }

        .register-container{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:30px 15px;
        }

        .register-card{
            width:420px;
            background:#fff;
            padding:40px;
            border-radius:14px;
            box-shadow:0 20px 40px rgba(0,0,0,.05);
        }

        .logo{
            text-align:center;
            font-weight:600;
            letter-spacing:2px;
            margin-bottom:8px;
        }

        .subtitle{
            color:#777;
            font-size:14px;
            text-align:center;
            margin-bottom:28px;
        }

        .form-control{
            border-radius:8px;
            padding:10px;
        }

        .btn-lux{
            background:#000;
            color:#fff;
            border:none;
            width:100%;
            padding:10px;
            border-radius:8px;
        }

        .btn-lux:hover{
            background:#c6a55c;
            color:#000;
        }

        .error-list{
            color:#dc3545;
            font-size:14px;
            margin-bottom:18px;
            padding-left:20px;
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

<div class="register-container">
    <div class="register-card">
        <div class="logo">SURO FRAGRANCE</div>
        <div class="subtitle"><?= esc($subtitle ?? 'Buat akun baru') ?></div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="text-danger small mb-3">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <ul class="error-list">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post" action="<?= esc($formAction ?? '/register') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?= esc(old('username')) ?>" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?= esc(old('email')) ?>" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password" required>
            </div>

            <div class="mb-3">
                <input type="password" name="pass_confirm" class="form-control" placeholder="Konfirmasi password" autocomplete="new-password" required>
            </div>

            <button type="submit" class="btn-lux"><?= esc($submitLabel ?? 'Daftar') ?></button>
        </form>

        <?php if (! ($isAdminForm ?? false)) : ?>
            <div class="auth-link">
                Sudah punya akun? <a href="/login/customer">Login pelanggan</a>
            </div>
        <?php else: ?>
            <div class="auth-link">
                Form ini hanya untuk admin.
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

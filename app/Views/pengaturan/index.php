<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Akun - Suro Fragrance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body{background:#f8f8f8;font-family:'Helvetica Neue',sans-serif;color:#111}
        .page{max-width:760px;margin:50px auto;padding:0 20px}
        .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
        .back{color:#555;text-decoration:none}.back:hover{color:#c6a55c}
        .card-lux{background:#fff;padding:34px;border-radius:14px;box-shadow:0 10px 25px rgba(0,0,0,.05)}
        .form-control{border-radius:8px;padding:10px}
        .btn-lux{background:#000;color:#fff;border:0;border-radius:8px;padding:10px 20px}
        .btn-lux:hover{background:#c6a55c;color:#000}
        .section-title{font-size:18px;font-weight:600;margin-bottom:18px}
        .hint{font-size:13px;color:#777}
    </style>
</head>
<body>
<main class="page">
    <div class="topbar">
        <div>
            <h2 class="mb-1">Pengaturan Akun</h2>
            <div class="text-muted">Kelola profil dan password akun yang sedang login.</div>
        </div>
        <a href="/dashboard" class="back"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <?php if (session()->getFlashdata('sukses')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('sukses')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card-lux">
        <?php if (session()->get('role') === 'admin') : ?>
            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="/admin/register" class="btn btn-outline-dark">
                    <i class="bi bi-person-plus"></i> Tambah Akun Admin
                </a>
                <a href="/logout" class="btn btn-dark">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-end mb-4">
                <a href="/logout" class="btn btn-dark">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        <?php endif; ?>

        <form action="/pengaturan/update" method="post">
            <?= csrf_field() ?>

            <div class="section-title">Informasi Profil</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= esc(old('username', $user->username)) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc(old('email', $user->email)) ?>" required>
                </div>
            </div>

            <hr class="my-4">

            <div class="section-title mb-1">Ubah Password</div>
            <div class="hint mb-3">Kosongkan bagian ini jika tidak ingin mengganti password.</div>
            <div class="mb-3">
                <label class="form-label">Password saat ini</label>
                <input type="password" name="current_password" class="form-control" autocomplete="current-password">
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Password baru</label>
                    <input type="password" name="new_password" class="form-control" autocomplete="new-password">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi password baru</label>
                    <input type="password" name="pass_confirm" class="form-control" autocomplete="new-password">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn-lux">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>

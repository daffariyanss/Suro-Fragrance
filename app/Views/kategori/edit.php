<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Kategori - Suro Fragrance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f8f8f8;font-family:'Helvetica Neue',sans-serif}
        .page{max-width:650px;margin:60px auto;padding:0 20px}
        .card-lux{background:#fff;padding:32px;border-radius:14px;box-shadow:0 10px 25px rgba(0,0,0,.05)}
        .form-control{border-radius:8px;padding:10px}
        .btn-lux{background:#000;color:#fff;border:0;border-radius:8px;padding:10px 18px}
        .btn-lux:hover{background:#c6a55c;color:#000}
        .back{color:#555;text-decoration:none}.back:hover{color:#c6a55c}
    </style>
</head>
<body>
<main class="page">
    <div class="card-lux">
        <h3 class="mb-4">Edit Kategori</h3>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/kategori/update/<?= $kategori['id_kategori'] ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Nama kategori</label>
                <input type="text" name="nama_kategori" class="form-control" value="<?= esc(old('nama_kategori', $kategori['nama_kategori'])) ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4"><?= esc(old('deskripsi', $kategori['deskripsi'] ?? '')) ?></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="/kategori" class="back">Kembali</a>
                <button type="submit" class="btn-lux">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>

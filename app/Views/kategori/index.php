<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kategori - Suro Fragrance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body{background:#f8f8f8;font-family:'Helvetica Neue',sans-serif;color:#111}
        .page{max-width:1100px;margin:50px auto;padding:0 20px}
        .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
        .back{color:#555;text-decoration:none}.back:hover{color:#c6a55c}
        .card-lux{background:#fff;border:0;border-radius:14px;box-shadow:0 10px 25px rgba(0,0,0,.05)}
        .form-control{border-radius:8px;padding:10px}
        .btn-lux{background:#000;color:#fff;border:0;border-radius:8px;padding:10px 18px}
        .btn-lux:hover{background:#c6a55c;color:#000}
        .table{margin:0}.table th{background:#000;color:#fff;font-weight:500}.table td{vertical-align:middle}
        .action{display:inline-block;text-decoration:none;border:0;border-radius:6px;padding:6px 10px;font-size:14px}
        .edit{background:#eaeaea;color:#000}.edit:hover{background:#c6a55c;color:#000}
        .delete{background:#111;color:#fff}.delete:hover{background:#c0392b}
    </style>
</head>
<body>
<main class="page">
    <div class="topbar">
        <div>
            <h2 class="mb-1">Kelola Kategori</h2>
            <div class="text-muted">Atur kategori yang digunakan oleh produk parfum.</div>
        </div>
        <a href="/dashboard" class="back"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <?php if (session()->getFlashdata('sukses')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('sukses')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card-lux p-4 mb-4">
        <h5 class="mb-3">Tambah Kategori</h5>
        <form action="/kategori/store" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nama kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="<?= esc(old('nama_kategori')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" value="<?= esc(old('deskripsi')) ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn-lux w-100">Tambah</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-lux overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Produk</th>
                    <th style="width:170px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($kategori as $item): ?>
                    <tr>
                        <td><?= esc($item['nama_kategori']) ?></td>
                        <td><?= esc($item['deskripsi'] ?: '-') ?></td>
                        <td><?= esc($item['jumlah_produk'] ?? 0) ?></td>
                        <td>
                            <a href="/kategori/edit/<?= $item['id_kategori'] ?>" class="action edit">Edit</a>
                            <form action="/kategori/delete/<?= $item['id_kategori'] ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="action delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($kategori)): ?>
                    <tr><td colspan="4" class="text-center text-muted p-4">Belum ada kategori.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>

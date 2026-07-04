<?php
/** @var string $title */
/** @var array $parfumFiltered */
/** @var array $semuaKategori */
/** @var array|null $kategoriDipilih */
/** @var int $id_aktif */
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Filter') ?> — Suro Fragrance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-gold: #b8972a;
            --clr-dark: #1a1a2e;
            --clr-light: #f8f5f0;
        }
        body { background-color: var(--clr-light); font-family: 'Georgia', serif; color: #333; }

        .page-header {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%);
            color: #fff;
            padding: 2.5rem 0 2rem;
            border-bottom: 3px solid var(--clr-gold);
        }

        .btn-filter {
            border: 1px solid var(--clr-gold);
            color: var(--clr-gold);
            background: transparent;
            border-radius: 20px;
            font-size: .82rem;
            padding: .3rem .9rem;
            margin: 3px;
        }
        .btn-filter.active,
        .btn-filter:hover {
            background: var(--clr-gold);
            color: #fff;
        }

        .badge-kategori {
            background-color: rgba(184,151,42,.15);
            color: var(--clr-gold);
            border: 1px solid var(--clr-gold);
            font-size: .75rem;
            padding: .35em .65em;
            border-radius: 20px;
        }

        .stok-ok   { color:#198754; font-weight:600; }
        .stok-warn { color:#fd7e14; font-weight:600; }
        .stok-habis{ color:#dc3545; font-weight:600; }
    </style>
</head>

<body>

<nav class="navbar navbar-dark" style="background:var(--clr-dark);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/suro-fragrance">Suro Fragrance</a>
    </div>
</nav>

<div class="page-header">
    <div class="container">
        <h1><?= esc($title ?? 'Filter Parfum') ?></h1>
    </div>
</div>

<div class="container my-4">

    <!-- FILTER BUTTON -->
    <div class="mb-3">
        <?php foreach ($semuaKategori as $kat): ?>
            <a href="/suro-fragrance/kategori/<?= $kat['id_kategori'] ?>"
               class="btn-filter <?= ($kat['id_kategori'] == $id_aktif) ? 'active' : '' ?>">
                <?= esc($kat['nama_kategori']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- INFO KATEGORI -->
    <?php if (!empty($kategoriDipilih)): ?>
        <div class="alert alert-dark">
            <strong><?= esc($kategoriDipilih['nama_kategori']) ?></strong><br>
            <?= esc($kategoriDipilih['deskripsi'] ?? 'Tidak ada deskripsi') ?>
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body">

            <h5>
                Hasil Filter:
                <?= esc($kategoriDipilih['nama_kategori'] ?? '-') ?>
                (<?= count($parfumFiltered ?? []) ?> item)
            </h5>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Brand</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
                </thead>
                <tbody>

                <?php if (!empty($parfumFiltered)): ?>
                    <?php foreach ($parfumFiltered as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($p['nama_parfum']) ?></td>
                            <td><?= esc($p['brand']) ?></td>
                            <td><span class="badge-kategori"><?= esc($p['nama_kategori']) ?></span></td>
                            <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($p['stok'] == 0): ?>
                                    <span class="stok-habis">Habis</span>
                                <?php elseif ($p['stok'] <= 5): ?>
                                    <span class="stok-warn"><?= $p['stok'] ?></span>
                                <?php else: ?>
                                    <span class="stok-ok"><?= $p['stok'] ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>
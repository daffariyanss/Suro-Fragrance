<?php
/** @var string $title */
/** @var array $q1_semuaParfum */
/** @var array $q2_extrait */
/** @var array $q3_premium */
/** @var array $q4_perKategori */
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Demonstrasi') ?> — Suro Fragrance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root { --clr-gold:#b8972a; --clr-dark:#1a1a2e; --clr-light:#f8f5f0; }
        body { background-color:var(--clr-light); font-family:'Georgia',serif; }

        .page-header {
            background:linear-gradient(135deg, #0d1117 0%, #161b22 100%);
            color:#fff;
            padding:2.5rem 0 2rem;
            border-bottom:3px solid var(--clr-gold);
        }

        .badge-kategori {
            background:rgba(184,151,42,.15);
            color:var(--clr-gold);
            border:1px solid var(--clr-gold);
            border-radius:20px;
            padding:.3em .6em;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark" style="background:var(--clr-dark);">
    <div class="container">
        <a href="/suro-fragrance" class="navbar-brand">Suro Fragrance</a>
        <a href="/suro-fragrance" class="btn btn-sm btn-outline-light">Kembali</a>
    </div>
</nav>

<div class="page-header">
    <div class="container">
        <h1><?= esc($title ?? 'Demonstrasi Query') ?></h1>
    </div>
</div>

<div class="container my-4">

    <!-- QUERY 1 -->
    <h5>1. JOIN</h5>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th><th>Nama</th><th>Brand</th><th>Kategori</th><th>Harga</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (($q1_semuaParfum ?? []) as $i => $p): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= esc($p['nama_parfum']) ?></td>
                <td><?= esc($p['brand']) ?></td>
                <td><span class="badge-kategori"><?= esc($p['nama_kategori']) ?></span></td>
                <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- QUERY 2 -->
    <h5>2. WHERE (Kategori)</h5>
    <table class="table table-hover">
        <tbody>
        <?php foreach (($q2_extrait ?? []) as $p): ?>
            <tr>
                <td><?= esc($p['nama_parfum']) ?></td>
                <td><?= esc($p['nama_kategori']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- QUERY 3 -->
    <h5>3. WHERE Harga</h5>
    <table class="table table-hover">
        <tbody>
        <?php foreach (($q3_premium ?? []) as $p): ?>
            <tr>
                <td><?= esc($p['nama_parfum']) ?></td>
                <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- QUERY 4 -->
    <h5>4. GROUP BY</h5>
    <table class="table table-hover">
        <tbody>
        <?php foreach (($q4_perKategori ?? []) as $k): ?>
            <tr>
                <td><?= esc($k['nama_kategori']) ?></td>
                <td><?= $k['jumlah_parfum'] ?></td>
                <td><?= $k['total_stok'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
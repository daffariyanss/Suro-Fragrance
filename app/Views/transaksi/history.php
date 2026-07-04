<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f8f8f8;font-family:Helvetica,Arial,sans-serif;">
<div class="container" style="max-width:1100px;margin-top:60px;padding-bottom:24px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <h2>Riwayat Pembelian</h2>
        <a href="/barang" class="btn btn-dark">Kembali ke Shop</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($transaksi)): ?>
                        <?php foreach ($transaksi as $t): ?>
                            <tr>
                                <td>#<?= esc($t['id_transaksi']) ?></td>
                                <td><?= esc($t['nama'] ?? '-') ?></td>
                                <td>Rp <?= number_format((int) $t['total'], 0, ',', '.') ?></td>
                                <td><?= esc($t['tanggal'] ?? '-') ?></td>
                                <td>
                                    <div class="d-flex flex-column flex-md-row gap-2">
                                        <a href="/riwayat-pembelian/edit/<?= esc($t['id_transaksi']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="/riwayat-pembelian/cancel/<?= esc($t['id_transaksi']) ?>" method="post" onsubmit="return confirm('Batalkan transaksi ini?')">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Batal</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada riwayat pembelian</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>

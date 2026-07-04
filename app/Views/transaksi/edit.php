<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f5f5f5; font-family: Helvetica, Arial, sans-serif; }
        .container-box { max-width: 960px; margin: 40px auto; background:#fff; padding:24px; border-radius:16px; }
        .produk-item { display:flex; gap:10px; margin-bottom:10px; }
        @media (max-width:768px){
            .container-box { margin: 16px; padding: 18px; }
            .produk-item { flex-direction:column; }
        }
    </style>
</head>
<body>
<div class="container-box">
    <h2 class="mb-4">Edit Transaksi #<?= esc($transaksi['id_transaksi']) ?></h2>
    <form action="/riwayat-pembelian/update/<?= esc($transaksi['id_transaksi']) ?>" method="post">
        <?= csrf_field() ?>
        <?php foreach (($details ?? []) as $i => $detail): ?>
            <div class="produk-item">
                <select name="produk[]" class="form-select" required>
                    <option value="">Pilih Parfum</option>
                    <?php foreach (($produk ?? []) as $pr): ?>
                        <option value="<?= esc($pr['id_parfum']) ?>" data-harga="<?= esc($pr['harga']) ?>" <?= ((int) $detail['id_produk'] === (int) $pr['id_parfum']) ? 'selected' : '' ?>>
                            <?= esc($pr['nama_parfum']) ?> (Rp <?= number_format((int) $pr['harga'], 0, ',', '.') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="qty[]" class="form-control" min="1" value="<?= esc($detail['qty']) ?>" required>
            </div>
        <?php endforeach; ?>

        <div class="d-flex gap-2 mt-3 flex-column flex-md-row">
            <button class="btn btn-dark" type="submit">Simpan Perubahan</button>
            <a href="/riwayat-pembelian" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>

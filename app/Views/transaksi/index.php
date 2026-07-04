<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f8f8f8;
            font-family:'Helvetica Neue', sans-serif;
        }

        .container{
            max-width:1100px;
            margin-top:60px;
        }

        h2{
            font-weight:600;
            letter-spacing:1px;
        }

        .btn-lux{
            background:#000;
            color:#fff;
            border:none;
            padding:10px 18px;
            border-radius:8px;
        }

        .btn-lux:hover{
            background:#c6a55c;
            color:#000;
        }

        .table-card{
            background:#fff;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }

        thead{
            background:#000;
            color:#fff;
        }

        tbody tr:hover{
            background:#f3f3f3;
        }

        .empty{
            padding:30px;
            text-align:center;
            color:#777;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Transaksi</h2>
        <a href="/transaksi/create" class="btn-lux">+ Transaksi Baru</a>
    </div>

    <div class="table-card">
        <table class="table mb-0">

            <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
            </thead>

            <tbody>
            <?php if (!empty($transaksi)): ?>
                <?php foreach ($transaksi as $t): ?>
                    <tr>
                        <td>#<?= $t['id_transaksi'] ?></td>
                        <td><?= esc($t['nama'] ?? $t['id_pelanggan']) ?></td>
                        <td>
                            Rp <?= number_format($t['total'], 0, ',', '.') ?>
                        </td>
                        <td>
                            <?= $t['tanggal'] ?? '-' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="empty">
                        Belum ada transaksi
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>
    </div>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Customer Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f8f8f8;
            font-family: 'Helvetica Neue', sans-serif;
            color:#111;
        }

        .container{
            max-width:1100px;
            margin-top:60px;
        }

        h2{
            font-weight:600;
            letter-spacing:1px;
        }

        /* BUTTON */
        .btn-lux{
            background:#000;
            color:#fff;
            border:none;
            padding:10px 18px;
            border-radius:8px;
            transition:.3s;
        }

        .btn-lux:hover{
            background:#c6a55c;
            color:#000;
        }

        /* CARD TABLE */
        .table-card{
            background:#fff;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }

        table{
            margin:0;
        }

        thead{
            background:#000;
            color:#fff;
        }

        th{
            font-weight:500;
            letter-spacing:.5px;
        }

        td{
            vertical-align:middle;
        }

        tbody tr{
            transition:.2s;
        }

        tbody tr:hover{
            background:#f3f3f3;
        }

        /* ACTION BUTTON */
        .aksi a{
            text-decoration:none;
            font-size:14px;
            margin-right:10px;
            padding:6px 10px;
            border-radius:6px;
            transition:.2s;
        }

        .edit{
            background:#eaeaea;
            color:#000;
        }

        .edit:hover{
            background:#c6a55c;
            color:#000;
        }

        .delete{
            background:#111;
            color:#fff;
        }

        .delete:hover{
            background:#c0392b;
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
        <h2>Customer Data</h2>
        <a href="/pelanggan/create" class="btn-lux">+ Add Customer</a>
    </div>

    <div class="table-card">
        <table class="table">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th style="width:150px;">Aksi</th>
            </tr>
            </thead>

            <tbody>
            <?php if (!empty($pelanggan)): ?>
                <?php foreach ($pelanggan as $p): ?>
                    <tr>
                        <td><?= esc($p['nama'] ?? '-') ?></td>
                        <td><?= esc($p['email'] ?? '-') ?></td>
                        <td><?= esc($p['no_hp'] ?? '-') ?></td>
                        <td><?= esc($p['alamat'] ?? '-') ?></td>
                        <td class="aksi">
                            <a href="/pelanggan/edit/<?= $p['id_pelanggan'] ?>" class="edit">Edit</a>
                            <a href="/pelanggan/delete/<?= $p['id_pelanggan'] ?>"
                               class="delete"
                               onclick="return confirm('Yakin hapus data?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">
                        Belum ada data pelanggan
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>
    </div>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f8f8f8;
            font-family:'Helvetica Neue', sans-serif;
        }

        .container{
            max-width:600px;
            margin-top:60px;
        }

        .card-form{
            background:#fff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }

        h3{
            margin-bottom:20px;
        }

        .form-control{
            border-radius:8px;
            padding:10px;
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

        .btn-back{
            text-decoration:none;
            color:#555;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card-form">
        <h3>Edit Customer</h3>

        <form action="/pelanggan/update/<?= $pelanggan['id_pelanggan'] ?>" method="post">

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control"
                       value="<?= esc($pelanggan['nama'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= esc($pelanggan['email'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control"
                       value="<?= esc($pelanggan['no_hp'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"><?= esc($pelanggan['alamat'] ?? '') ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/pelanggan" class="btn-back">← Kembali</a>
                <button type="submit" class="btn-lux">Update</button>
            </div>

        </form>
    </div>

</div>

</body>
</html>
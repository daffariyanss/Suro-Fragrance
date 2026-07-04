<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            font-family: 'Helvetica Neue', sans-serif;
        }

        .container-box {
            max-width: 900px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .btn-lux {
            background: black;
            color: white;
            border: none;
        }

        .btn-lux:hover {
            background: #c6a55c;
            color: black;
        }

        .produk-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        .total-box {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .container-box {
                margin: 16px;
                padding: 18px;
                border-radius: 14px;
            }

            .d-flex.gap-2 {
                flex-direction: column;
            }

            .produk-item {
                flex-direction: column;
                align-items: stretch;
            }

            .produk-item .form-control,
            .produk-item .btn {
                width: 100%;
            }

            .total-box {
                text-align: left;
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

<div class="container-box">

    <h2>Transaksi Penjualan</h2>

    <form action="/transaksi/store" method="post">
        <?= csrf_field() ?>

        <?php if (!empty($isAdmin)): ?>
            <!-- PILIH / TAMBAH PELANGGAN -->
            <div class="mb-3">
                <label>Pelanggan</label>
                <div class="d-flex gap-2 flex-column flex-md-row">
                    <select name="id_pelanggan" id="select-pelanggan" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <option value="new">-- Tambah Pelanggan Baru --</option>
                        <?php foreach ($pelanggan as $p): ?>
                            <option value="<?= $p['id_pelanggan'] ?>">
                                <?= $p['nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="nama_pelanggan_baru" id="nama-pelanggan-baru" class="form-control" placeholder="Masukkan nama baru" style="display:none">
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-3">
                Transaksi akan dibuat untuk akun pelanggan yang sedang login.
            </div>
        <?php endif; ?>

        <!-- PRODUK LIST -->
        <div id="produk-wrapper">

            <div class="produk-item">
                <select name="produk[]" class="form-control produk" required>
                    <option value="">Pilih Parfum</option>
                    <?php foreach ($produk as $pr): ?>
                        <option value="<?= $pr['id_parfum'] ?>" data-harga="<?= $pr['harga'] ?>" <?= (($selectedProduk ?? 0) == $pr['id_parfum']) ? 'selected' : '' ?>>
                            <?= $pr['nama_parfum'] ?> (Rp <?= number_format($pr['harga']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="number" name="qty[]" class="form-control qty" placeholder="Qty" min="1" value="1" required>

                <button type="button" class="btn btn-danger" onclick="hapusBaris(this)">X</button>
            </div>

        </div>

        <!-- TAMBAH PRODUK -->
        <button type="button" class="btn btn-secondary mb-3 w-100 w-md-auto" onclick="tambahBaris()">
            + Tambah Produk
        </button>

        <!-- TOTAL -->
        <div class="total-box">
            Total: Rp <span id="total">0</span>
        </div>

        <!-- SUBMIT -->
        <button class="btn btn-lux w-100 mt-3 py-2">Simpan Transaksi</button>

    </form>

</div>

<script>
    function tambahBaris() {
        let wrapper = document.getElementById('produk-wrapper');

        let html = `
    <div class="produk-item">
                <select name="produk[]" class="form-control produk">
                    <option value="">Pilih Parfum</option>
                    <?php foreach ($produk as $pr): ?>
                        <option value="<?= $pr['id_parfum'] ?>" data-harga="<?= $pr['harga'] ?>">
                            <?= $pr['nama_parfum'] ?>
                        </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="qty[]" class="form-control qty" min="1">

        <button type="button" class="btn btn-danger" onclick="hapusBaris(this)">X</button>
    </div>
    `;

        wrapper.insertAdjacentHTML('beforeend', html);
    }

    function hapusBaris(btn) {
        btn.parentElement.remove();
        hitungTotal();
    }

    document.addEventListener('change', function(e){
        if (e.target.classList.contains('produk') || e.target.classList.contains('qty')) {
            hitungTotal();
        }
    });

    document.addEventListener('input', function(e){
        if (e.target.classList.contains('qty')) {
            hitungTotal();
        }
    });

    const selectPelanggan = document.getElementById('select-pelanggan');
    if (selectPelanggan) {
        selectPelanggan.addEventListener('change', function(e){
            const el = document.getElementById('nama-pelanggan-baru');
            if (this.value === 'new') {
                el.style.display = '';
                el.required = true;
            } else {
                el.style.display = 'none';
                el.required = false;
            }
        });
    }

    function hitungTotal() {
        let total = 0;

        document.querySelectorAll('.produk-item').forEach(row => {
            let select = row.querySelector('.produk');
            let qty = row.querySelector('.qty').value;

            let harga = select.options[select.selectedIndex]?.dataset.harga;

            if (harga && qty) {
                total += parseInt(harga) * parseInt(qty);
            }
        });

        document.getElementById('total').innerText =
            new Intl.NumberFormat('id-ID').format(total);
    }

    hitungTotal();
</script>

</body>
</html>

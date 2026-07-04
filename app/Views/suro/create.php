<?php
/** @var array $parfum */
/** @var array $semuaKategori */
?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    body{
        background:#f5f5f3;
        color:#111;
    }

    .card-glass{
        background:#fff;
        border:1px solid #e5e5e5;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
    }

    h2{
        font-family:'Playfair Display', serif;
        font-size:32px;
        letter-spacing:1px;
        text-align:center;
        margin-bottom:30px;
    }

    .form-control, .form-select, textarea{
        background:#fafafa !important;
        border:1px solid #ddd;
        color:#111 !important;
        border-radius:10px;
        padding:12px;
    }

    .form-control::placeholder,
    textarea::placeholder{
        color:#999;
    }

    .form-control:focus, .form-select:focus{
        border-color:#111;
        box-shadow:none;
    }

    .btn-gold{
        background:#111;
        color:#fff;
        border:none;
        border-radius:10px;
        padding:12px;
        font-weight:500;
        transition:.3s;
    }

    .btn-gold:hover{
        background:#333;
    }

    .btn-cancel{
        background:#e5e5e5;
        color:#111;
        border:none;
        border-radius:10px;
        padding:12px;
    }

    #selected-preview{
        border-radius:12px;
        border:1px solid #eee;
    }
</style>

    <div class="container py-5" style="max-width:700px">

        <h2 class="mb-4 fade-item">Tambah Parfum</h2>

        <!-- ERROR -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger fade-item">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $field => $errors): ?>
                        <?php if (is_array($errors)): ?>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars((string)$error) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><?= htmlspecialchars((string)$errors) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card-glass p-4 fade-item">

            <?php if (session()->get('role') === 'admin'): ?>
            <form action="/barang/store" method="POST">
                <?= csrf_field() ?>

                <!-- NAMA -->
                <input id="nama_parfum" name="nama_parfum"
                       value="<?= old('nama_parfum') ?>"
                       class="form-control mb-3"
                       placeholder="Nama parfum" required>

                <!-- BRAND -->
                <input id="brand" name="brand"
                       value="<?= old('brand') ?>"
                       class="form-control mb-3"
                       placeholder="Brand" required>

                <!-- AUTO IMAGE BUTTON -->
                <div class="mb-3">
                    <button type="button" class="btn btn-gold w-100" onclick="cariGambar()">
                        🔍 Auto Cari Gambar
                    </button>
                </div>

                <!-- PREVIEW RESULT -->
                <div id="preview-images" class="d-flex gap-2 flex-wrap mb-3"></div>

                <!-- URL GAMBAR -->
                <input id="gambar" name="gambar"
                       value="<?= old('gambar') ?>"
                       class="form-control mb-3"
                       placeholder="URL gambar (auto / manual)">

                <!-- SELECTED PREVIEW -->
                <div class="text-center mb-4">
                    <img id="selected-preview"
                         src="<?= old('gambar') ?: 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23ddd%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 fill=%22%23999%22%3EPreview%3C/text%3E%3C/svg%3E' ?>"
                         style="max-height:150px; border-radius:12px;">
                </div>

                <!-- HARGA -->
                <input name="harga"
                       value="<?= old('harga') ?>"
                       type="number"
                       class="form-control mb-3"
                       placeholder="Harga" required>

                <!-- STOK -->
                <input name="stok"
                       value="<?= old('stok') ?>"
                       type="number"
                       class="form-control mb-3"
                       placeholder="Stok" required>

                <!-- KATEGORI -->
                <select name="id_kategori" class="form-select mb-3" required>
                    <option value="">Pilih kategori</option>
                    <?php foreach ($semuaKategori as $k): ?>
                        <option value="<?= $k['id_kategori'] ?>"
                                <?= old('id_kategori') == $k['id_kategori'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars((string)$k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- DESKRIPSI -->
                <textarea name="deskripsi"
                          class="form-control mb-3"
                          placeholder="Deskripsi"><?= old('deskripsi') ?></textarea>

                <!-- ACTION -->
                <div class="d-flex gap-2">
                    <button class="btn btn-gold w-100">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="/barang" class="btn btn-cancel w-100">
                        Batal
                    </a>
                </div>

            </form>
            <?php else: ?>
                <div class="alert alert-danger">Akses ditolak. Hanya admin yang dapat menambah parfum.</div>
            <?php endif; ?>

        </div>

    </div>

    <!-- ============================= -->
    <!-- UNSPLASH KEY -->
    <!-- ============================= -->
    <script>
        const UNSPLASH_KEY = "<?= getenv('UNSPLASH_ACCESS_KEY') ?>";
    </script>

    <!-- ============================= -->
    <!-- AUTO IMAGE + MANUAL SUPPORT -->
    <!-- ============================= -->
    <script>
        async function cariGambar() {
            const nama  = document.getElementById('nama_parfum').value;
            const brand = document.getElementById('brand').value;

            if (!nama) {
                alert('Isi nama parfum dulu');
                return;
            }

            if (!UNSPLASH_KEY) {
                alert('UNSPLASH KEY belum terbaca (.env)');
                return;
            }

            const query = `${brand} ${nama} perfume bottle`;

            const preview = document.getElementById('preview-images');
            preview.innerHTML = "Loading...";

            try {
                const res = await fetch(
                    `https://api.unsplash.com/search/photos?query=${encodeURIComponent(query)}&per_page=6&client_id=${UNSPLASH_KEY}`
                );

                const data = await res.json();

                if (!data.results || data.results.length === 0) {
                    preview.innerHTML = 'Gambar tidak ditemukan';
                    return;
                }

                preview.innerHTML = '';

                data.results.forEach(img => {
                    const el = document.createElement('img');
                    el.src = img.urls.regular;

                    el.style.width = '80px';
                    el.style.height = '80px';
                    el.style.objectFit = 'cover';
                    el.style.borderRadius = '10px';
                    el.style.cursor = 'pointer';
                    el.style.transition = '.3s';

                    el.onmouseover = () => el.style.transform = 'scale(1.1)';
                    el.onmouseout  = () => el.style.transform = 'scale(1)';

                    el.onclick = () => {
                        const url = img.urls.full || img.urls.regular;
                        const input = document.getElementById('gambar');
                        const previewImg = document.getElementById('selected-preview');

                        input.value = url;
                        previewImg.src = url;
                    };

                    preview.appendChild(el);
                });

            } catch (err) {
                console.error(err);
                preview.innerHTML = 'Gagal ambil gambar';
            }
        }

        document.getElementById('gambar').addEventListener('input', function(){
            let val = this.value.trim();
            const preview = document.getElementById('selected-preview');

            // auto fix kalau user paste tanpa https
            if (val && !val.startsWith('http')) {
                val = 'https://' + val;
                this.value = val;
            }

            if (val) {
                preview.src = val;
            } else {
                preview.src = 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23ddd%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 fill=%22%23999%22%3EPreview%3C/text%3E%3C/svg%3E';
            }
        });
    </script>

<?= $this->endSection() ?>
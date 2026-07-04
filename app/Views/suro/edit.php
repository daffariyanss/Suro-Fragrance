<?php
/** @var array $parfum */
/** @var array $semuaKategori */
?>

<?= $this->extend('layouts/luxury') ?>
<?= $this->section('content') ?>

<div class="container py-5" style="max-width:700px">

    <h2 class="mb-4 fade-in">Edit Parfum</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger fade-in">
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

    <div class="card-lux p-4 fade-in">

        <?php if (session()->get('role') === 'admin'): ?>
        <form action="/barang/update/<?= $parfum['id_parfum'] ?>" method="POST">
            <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars((string)($parfum['gambar'] ?? '')) ?>">
            <?= csrf_field() ?>

            <!-- NAMA -->
            <input id="nama_parfum" name="nama_parfum"
                   value="<?= old('nama_parfum', $parfum['nama_parfum']) ?>"
                   class="form-control mb-3"
                   placeholder="Nama parfum" required>

            <!-- BRAND -->
            <input id="brand" name="brand"
                   value="<?= old('brand', $parfum['brand']) ?>"
                   class="form-control mb-3"
                   placeholder="Brand" required>

            <!-- AUTO IMAGE BUTTON -->
            <div class="mb-3">
                <button type="button" onclick="cariGambar()" class="btn btn-gold w-100">
                    🔍 Auto Cari Gambar
                </button>
            </div>

            <!-- RESULT PREVIEW LIST -->
            <div id="preview-images" class="d-flex flex-wrap gap-2 mb-3"></div>

            <!-- URL GAMBAR -->
            <input id="gambar" name="gambar"
                   value="<?= old('gambar', $parfum['gambar'] ?? '') ?>"
                   class="form-control mb-3"
                   placeholder="Paste URL gambar (Google / Unsplash / dll)">

            <!-- SELECTED PREVIEW -->
            <div class="text-center mb-4">
                <img id="preview"
                     src="<?= !empty($parfum['gambar']) ? esc($parfum['gambar']) : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23ddd%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 fill=%22%23999%22%3EPreview%3C/text%3E%3C/svg%3E' ?>"
                     style="max-height:160px; border-radius:12px; transition:.3s;"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23ddd%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 fill=%22%23999%22%3EPreview%3C/text%3E%3C/svg%3E'">
            </div>

            <!-- HARGA -->
            <input name="harga"
                   value="<?= old('harga', $parfum['harga']) ?>"
                   type="number"
                   class="form-control mb-3"
                   placeholder="Harga" required>

            <!-- STOK -->
            <input name="stok"
                   value="<?= old('stok', $parfum['stok']) ?>"
                   type="number"
                   class="form-control mb-3"
                   placeholder="Stok" required>

            <!-- KATEGORI -->
            <select name="id_kategori" class="form-select mb-3" required>
                <?php foreach ($semuaKategori as $k): ?>
                    <option value="<?= $k['id_kategori'] ?>"
                        <?= $k['id_kategori'] == $parfum['id_kategori'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars((string)$k['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- DESKRIPSI -->
            <textarea name="deskripsi"
                      class="form-control mb-3"
                      placeholder="Deskripsi"><?= old('deskripsi', $parfum['deskripsi']) ?></textarea>

            <!-- ACTION -->
            <div class="d-flex gap-2">
                <button class="btn btn-gold w-100">
                    Update
                </button>

                <a href="/barang" class="btn btn-secondary w-100">
                    Batal
                </a>
            </div>

        </form>
        <?php else: ?>
            <div class="alert alert-danger">Akses ditolak. Hanya admin yang dapat mengubah parfum.</div>
        <?php endif; ?>

    </div>

</div>

<script>
const UNSPLASH_KEY = "<?= getenv('UNSPLASH_ACCESS_KEY') ?>";

async function cariGambar() {
    const nama  = document.getElementById('nama_parfum').value;
    const brand = document.getElementById('brand').value;

    if (!nama) {
        alert('Isi nama parfum dulu');
        return;
    }

    const query = `${brand} ${nama} perfume bottle product`;

    const preview = document.getElementById('preview-images');
    preview.innerHTML = "Loading...";

    try {
        const res = await fetch(
            `https://api.unsplash.com/search/photos?query=${encodeURIComponent(query)}&per_page=6`,
            {
                headers: {
                    Authorization: `Client-ID ${UNSPLASH_KEY}`
                }
            }
        );

        const data = await res.json();
        preview.innerHTML = '';

        if (!data.results || data.results.length === 0) {
            preview.innerHTML = 'Gambar tidak ditemukan';
            return;
        }

        data.results.forEach(img => {
            const el = document.createElement('img');
            el.src = img.urls.regular;

            el.style.width = '80px';
            el.style.height = '80px';
            el.style.objectFit = 'cover';
            el.style.borderRadius = '10px';
            el.style.cursor = 'pointer';
            el.style.transition = '.3s';

            el.onclick = () => {
                const url = img.urls.full || img.urls.regular;
                document.getElementById('gambar').value = url;

                const previewImg = document.getElementById('preview');
                previewImg.src = url;
                previewImg.style.opacity = '0';
                setTimeout(() => {
                    previewImg.style.opacity = '1';
                }, 150);
            };

            preview.appendChild(el);
        });

    } catch (err) {
        console.error(err);
        preview.innerHTML = 'Gagal ambil gambar';
    }
}

// SUPPORT MANUAL (Google / link luar)
document.getElementById('gambar').addEventListener('input', function(){
    let val = this.value.trim();
    const preview = document.getElementById('preview');

    // auto fix jika user paste tanpa https
    if (val && !val.startsWith('http')) {
        val = 'https://' + val;
        this.value = val;
    }

    if (val) {
        preview.src = val;
    } else {
        preview.src = "data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3Crect fill=%22%23ddd%22 width=%22150%22 height=%22150%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 fill=%22%23999%22%3EPreview%3C/text%3E%3C/svg%3E";
    }
});
</script>

<?= $this->endSection() ?>
<?php
$unsplashKey = getenv('UNSPLASH_ACCESS_KEY');
?>

<?= $this->extend('layouts/luxury') ?>
<?= $this->section('content') ?>

<div class="container py-5">

    <h1 class="mb-5 text-center" style="letter-spacing:2px; font-family:Georgia,serif;">
        <?= htmlspecialchars((string)($title ?? 'Suro Fragrance Collection')) ?>
    </h1>

    <?php if (session()->getFlashdata('sukses')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('sukses') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->get('role') === 'admin') : ?>
        <div class="text-end mb-4">
            <a href="/barang/create" class="btn-edit" style="text-decoration:none; padding:10px 25px; display:inline-block; border-radius:25px;">
                <i class="bi bi-plus-lg"></i> Tambah Parfum Baru
            </a>
        </div>
    <?php endif; ?>

    <div class="row g-4 g-md-5">

        <?php if (isset($parfum) && !empty($parfum) && is_array($parfum)): ?>
            <?php foreach ($parfum as $p): ?>

        <div class="col-12 col-sm-6 col-lg-4">

            <div class="parfum-item text-center" data-id="<?= $p['id_parfum'] ?>">

                <!-- IMAGE -->
                <div class="img-wrap mb-3">
                    <?php
                        // Placeholder SVG lokal untuk performa lebih baik
                        $placeholderSvg = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="300" height="300"%3E%3Crect fill="%23ddd" width="300" height="300"/%3E%3Ctext x="50%" y="50%" font-size="18" text-anchor="middle" dominant-baseline="middle" fill="%23999"%3EParfum Image%3C/text%3E%3C/svg%3E';
                        $imgSrc = !empty($p['gambar']) && filter_var($p['gambar'], FILTER_VALIDATE_URL)
                            ? $p['gambar']
                            : $placeholderSvg;
                    ?>
                    <img
                        src="<?= htmlspecialchars((string)$imgSrc) ?>"
                        alt="<?= htmlspecialchars((string)$p['nama_parfum']) ?>"
                        data-nama="<?= htmlspecialchars((string)$p['nama_parfum']) ?>"
                        data-brand="<?= htmlspecialchars((string)$p['brand']) ?>"
                        class="img-fluid parfum-img"
                        loading="lazy"
                        onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Crect fill=%22%23ddd%22 width=%22300%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2218%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 fill=%22%23999%22%3EParfum Image%3C/text%3E%3C/svg%3E'">
                </div>

                <!-- NAME -->
                <h5 class="fw-semibold" style="letter-spacing:1px;">
                    <?= htmlspecialchars((string)$p['nama_parfum']) ?>
                </h5>

                <!-- BRAND -->
                <p class="text-muted" style="font-size:12px;">
                    <?= htmlspecialchars((string)$p['brand']) ?>
                </p>

                <!-- CATEGORY -->
                <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase;">
                    <?= htmlspecialchars((string)$p['nama_kategori']) ?>
                </p>

                <!-- DESC -->
                <p class="desc">
                    <?= htmlspecialchars((string)$p['deskripsi']) ?>
                </p>

                <!-- PRICE -->
                <p class="price">
                    Rp <?= number_format($p['harga'],0,',','.') ?>
                </p>

                <!-- STOCK -->
                <p class="stock">
                    <?php if ($p['stok'] <= 5): ?>
                        Low stock (<?= $p['stok'] ?>)
                    <?php else: ?>
                        In stock
                    <?php endif; ?>
                </p>

                <!-- ACTION -->
                <?php if (session()->get('role') !== 'admin') : ?>
                    <div class="actions" style="display:flex; opacity:1; transform:none;">
                        <a href="/transaksi/create?produk=<?= $p['id_parfum'] ?>" class="btn-edit">Beli</a>
                    </div>
                <?php endif; ?>

                <?php if (session()->get('role') === 'admin') : ?>
                    <div class="actions">
                        <a href="/barang/edit/<?= $p['id_parfum'] ?>" class="btn-edit">Edit</a>
                        <a href="/barang/delete/<?= $p['id_parfum'] ?>" class="btn-delete" onclick="return confirm('Hapus data?')">Delete</a>
                    </div>
                <?php endif; ?>

            </div>

        </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Data parfum tidak ditemukan.</p>
        <?php endif; ?>

    </div>

</div>

<style>
.parfum-item{
    cursor:pointer;
    padding:20px;
    transition:.4s;
    background:#fff;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}

.parfum-item:hover{
    transform:translateY(-5px);
}

.img-wrap{
    height:260px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.parfum-img{
    max-height:100%;
    object-fit:contain;
}

.desc{
    font-size:13px;
    color:#666;
    min-height:40px;
}

.price{
    font-weight:600;
    margin-top:10px;
}

.stock{
    font-size:12px;
    color:#888;
}

.actions{
    margin-top:12px;
    display:none;
    gap:12px;
    justify-content:center;
    opacity:0;
    transform:translateY(10px);
    transition:.3s ease;
}

.parfum-item.active .actions{
    display:flex;
    opacity:1;
    transform:translateY(0);
}

.btn-edit,
.btn-delete{
    padding:6px 14px;
    font-size:12px;
    text-decoration:none;
    border-radius:20px;
    transition:.3s;
}

.btn-edit{
    border:1px solid #000;
    color:#000;
    background:transparent;
}

.btn-edit:hover{
    background:#000;
    color:#fff;
}

.btn-delete{
    border:1px solid #c00;
    color:#c00;
    background:transparent;
}

.btn-delete:hover{
    background:#c00;
    color:#fff;
}

@media (max-width: 768px){
    .parfum-item{
        padding:16px;
    }
    .img-wrap{
        height:220px;
    }
    h1{
        font-size:2rem;
    }
    .actions{
        flex-direction:column;
        gap:8px;
    }
    .btn-edit,
    .btn-delete{
        width:100%;
    }
}
</style>

<script>
const UNSPLASH_KEY = "<?= $unsplashKey ?>";

async function loadImages(){
    const items = document.querySelectorAll('.parfum-img');

    for(const img of items){

        let currentSrc = img.getAttribute('src');

        const isValid =
            currentSrc &&
            currentSrc !== '' &&
            !currentSrc.includes('placeholder') &&
            currentSrc.startsWith('http');

        if(isValid){
            continue;
        }

        const query = img.dataset.brand + " " + img.dataset.nama + " perfume";

        try{
            const res = await fetch(`https://api.unsplash.com/search/photos?query=${query}&per_page=1`,{
                headers:{ Authorization:`Client-ID ${UNSPLASH_KEY}` }
            });

            const data = await res.json();

            if(data.results.length > 0){
                img.src = data.results[0].urls.regular;
            }
        }catch(e){
            console.log("Unsplash error:", e);
        }
    }
}

loadImages();

document.querySelectorAll('.parfum-item').forEach(card=>{
    card.addEventListener('click',()=>{
        const isActive = card.classList.contains('active');

        document.querySelectorAll('.parfum-item').forEach(c=>c.classList.remove('active'));

        if(!isActive){
            card.classList.add('active');
        }
    });
});
</script>

<?= $this->endSection() ?>

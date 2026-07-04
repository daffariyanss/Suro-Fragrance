<nav class="navbar px-3 px-md-4 py-3" style="background:#ffffff; border-bottom:1px solid #eee;">

    <div class="nav-wrap">
        <!-- LOGO -->
        <a href="/barang" class="navbar-brand" style="font-family:'Playfair Display', serif; font-size:18px; letter-spacing:2px;">
            SURO FRAGRANCE
        </a>

        <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- MENU -->
    <div class="nav-menu" style="font-size:13px;">
        <a href="/barang" style="text-decoration:none; color:#111;">
            Shop
        </a>

        <?php if (session()->get('role') === 'admin') : ?>
            <a href="/barang/create" style="text-decoration:none; color:#111;">
                Add
            </a>
            <a href="/transaksi" style="text-decoration:none; color:#111;">
                Transaksi
            </a>
            <a href="/transaksi/create" style="text-decoration:none; color:#111;">
                Kasir
            </a>
        <?php else: ?>
            <a href="/riwayat-pembelian" style="text-decoration:none; color:#111;">
                Riwayat Pembelian
            </a>
        <?php endif; ?>
        <a href="/dashboard" style="text-decoration:none; color:#111;">
            Dashboard
        </a>

    </div>

</nav>

<style>
    .navbar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
    }
    .nav-wrap{
        width:100%;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
    }
    .nav-toggle{
        display:none;
        border:1px solid #ddd;
        background:#fff;
        border-radius:10px;
        width:42px;
        height:42px;
        align-items:center;
        justify-content:center;
        gap:4px;
        flex-direction:column;
    }
    .nav-toggle span{
        display:block;
        width:18px;
        height:2px;
        background:#111;
        border-radius:2px;
    }
    .nav-menu{
        display:flex;
        align-items:center;
        gap:18px;
        flex-wrap:wrap;
        width:100%;
        justify-content:flex-end;
    }
    @media (max-width: 768px){
        .nav-toggle{display:flex;}
        .nav-menu{
            display:none;
            width:100%;
            justify-content:flex-start;
            padding-top:8px;
            border-top:1px solid #eee;
        }
        .nav-menu.open{display:flex;}
        .nav-menu a{
            padding:8px 0;
            width:100%;
        }
    }
</style>

<script>
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            const open = navMenu.classList.toggle('open');
            navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
</script>

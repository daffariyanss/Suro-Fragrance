<?php helper('text'); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?> — Suro Fragrance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- FONT LUXURY -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root{
            --gold:#c6a55c;
            --dark:#0b0b0c;
            --soft:#eae6df;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            background:#f8f8f8;
            color:#111;
            font-family:'Inter',sans-serif;
        }

        h1,h2,h3,h4,h5,h6{
            font-family:'Playfair Display',serif;
            letter-spacing:1px;
        }

        /* LAYOUT SIDEBAR */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #fff;
            border-right: 1px solid #eee;
            padding: 30px 0;
            overflow-y: auto;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            transition: transform .25s ease;
            z-index: 20;
        }

        .sidebar-brand {
            padding: 0 20px 30px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .sidebar-brand h5 {
            color: var(--dark);
            font-size: 1.2rem;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            transition: 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: var(--gold);
            background: #f5f5f5;
            border-left-color: var(--gold);
        }

        .sidebar-menu a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, var(--gold), #a8842c);
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .header-welcome {
            font-size: 0.95rem;
        }

        .header-welcome strong {
            display: block;
            font-size: 1.2rem;
            margin-top: 5px;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
            min-width: 0;
        }

        /* SECTION TITLE */
        .section-title {
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* DASHBOARD CARDS */
        .stat-card {
            background: #fff;
            border: none;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .stat-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .stat-card .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.8rem;
        }

        .stat-card.card-blue .icon-wrapper {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-card.card-green .icon-wrapper {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .stat-card.card-cyan .icon-wrapper {
            background: rgba(6, 182, 212, 0.1);
            color: #06b6d4;
        }

        .stat-card.card-pink .icon-wrapper {
            background: rgba(236, 72, 153, 0.1);
            color: #ec4899;
        }

        .stat-card.card-orange .icon-wrapper {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
        }

        .stat-card h6 {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        /* SECTIONS */
        .dashboard-section {
            margin-bottom: 40px;
        }

        .section-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .mobile-topbar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: #fff;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 15;
        }

        .menu-btn {
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 10px;
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 280px;
                transform: translateX(-100%);
                box-shadow: 0 20px 40px rgba(0,0,0,.16);
            }

            .content {
                margin-left: 0;
            }

            .main-content {
                padding: 18px 14px 28px;
            }

            .section-cards {
                grid-template-columns: 1fr;
            }

            .header {
                display: none;
            }

            .mobile-topbar {
                display: flex;
                padding-left: 14px;
                padding-right: 14px;
            }

            .wrapper.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .wrapper.sidebar-open::before{
                content:'';
                position:fixed;
                inset:0;
                background:rgba(0,0,0,.35);
                z-index:10;
            }

            .stat-card {
                text-align: left;
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .stat-card .icon-wrapper {
                margin: 0;
                flex: 0 0 56px;
            }

            .stat-number {
                font-size: 1.7rem;
            }

            .stat-card h6 {
                margin-bottom: 6px;
            }

            .section-title {
                font-size: 1.1rem;
                margin-bottom: 14px;
            }

            .dashboard-section {
                margin-bottom: 28px;
            }

            .stat-card {
                border-radius: 14px;
                padding: 16px;
            }

            .main-content .alert {
                border-radius: 14px;
            }
        }
    </style>
</head>

<body>

<div class="wrapper">
    <div class="mobile-topbar">
        <strong>Suro Fragrance</strong>
        <button class="menu-btn" type="button" aria-label="Buka menu">
            <i class="bi bi-list"></i>
        </button>
    </div>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h5>Suro Fragrance</h5>
        </div>
        <ul class="sidebar-menu">
            <li><a href="/dashboard" class="active"><i class="bi bi-graph-up"></i> Dashboard</a></li>
            <li><a href="/barang"><i class="bi bi-box"></i> Produk</a></li>
            <?php if (session()->get('role') === 'admin') : ?>
                <li><a href="/kategori"><i class="bi bi-tags"></i> Kategori</a></li>
                <li><a href="/pelanggan"><i class="bi bi-people"></i> Pelanggan</a></li>
                <li><a href="/transaksi"><i class="bi bi-receipt"></i> Transaksi</a></li>
            <?php endif; ?>
            <li><a href="/pengaturan"><i class="bi bi-gear"></i> Pengaturan</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="content">
        <!-- HEADER -->
        <div class="header">
            <div class="header-welcome">
                Selamat datang,
                <strong><?= esc(session()->get('username') ?? 'Pengguna') ?></strong>
            </div>
            <div class="header-user">
                <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger mb-4">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('sukses')) : ?>
                <div class="alert alert-success mb-4">
                    <?= esc(session()->getFlashdata('sukses')) ?>
                </div>
            <?php endif; ?>

            <!-- RINGKASAN FRAGRANCE -->
            <div class="dashboard-section">
                <h6 class="section-title">Ringkasan Produk</h6>
                <div class="section-cards">
                    <!-- Total Produk -->
                    <div class="stat-card card-blue">
                        <div class="icon-wrapper">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h6>Total Produk</h6>
                        <div class="stat-number"><?= esc($total ?? 0) ?></div>
                    </div>

                    <?php if (session()->get('role') === 'admin') : ?>
                        <!-- Total Kategori -->
                        <div class="stat-card card-green">
                            <div class="icon-wrapper"><i class="bi bi-tags"></i></div>
                            <h6>Total Kategori</h6>
                            <div class="stat-number"><?= esc($total_kategori ?? 0) ?></div>
                        </div>
                        <!-- Total Pelanggan -->
                        <div class="stat-card card-cyan">
                            <div class="icon-wrapper"><i class="bi bi-people"></i></div>
                            <h6>Total Pelanggan</h6>
                            <div class="stat-number"><?= esc($total_pelanggan ?? 0) ?></div>
                        </div>
                        <!-- Total Penjualan -->
                        <div class="stat-card card-pink">
                            <div class="icon-wrapper"><i class="bi bi-graph-up"></i></div>
                            <h6>Total Penjualan</h6>
                            <div class="stat-number"><?= esc($total_penjualan ?? 0) ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (session()->get('role') === 'admin') : ?>
                <!-- AKTIVITAS HARIAN -->
                <div class="dashboard-section">
                    <h6 class="section-title">Kegiatan Harian</h6>
                    <div class="section-cards">
                        <!-- Penjualan Hari Ini -->
                        <div class="stat-card card-orange">
                            <div class="icon-wrapper">
                                <i class="bi bi-lightning"></i>
                            </div>
                            <div>
                                <h6>Penjualan Hari Ini</h6>
                                <div class="stat-number">0</div>
                            </div>
                        </div>

                        <!-- Pengunjung Hari Ini -->
                        <div class="stat-card card-blue">
                            <div class="icon-wrapper">
                                <i class="bi bi-eye"></i>
                            </div>
                            <div>
                                <h6>Pengunjung Hari Ini</h6>
                                <div class="stat-number">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const wrapper = document.querySelector('.wrapper');
    const menuBtn = document.querySelector('.menu-btn');
    const sidebar = document.querySelector('.sidebar');

    if (menuBtn && wrapper) {
        menuBtn.addEventListener('click', () => {
            wrapper.classList.toggle('sidebar-open');
        });
    }

    document.addEventListener('click', (e) => {
        if (!wrapper || !sidebar) return;
        if (window.innerWidth > 768) return;
        if (wrapper.classList.contains('sidebar-open') && !sidebar.contains(e.target) && !e.target.closest('.menu-btn')) {
            wrapper.classList.remove('sidebar-open');
        }
    });
</script>
</body>
</html>

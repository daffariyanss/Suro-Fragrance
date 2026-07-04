<?php helper('text'); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suro Fragrance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT (YSL FEEL) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin:0;
            height:100vh;
            font-family:'Playfair Display', serif;
            overflow:hidden;
        }

        /* HERO BACKGROUND */
        .hero {
            height:100vh;
            background:url('https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=1600') center/cover no-repeat;
            position:relative;
            color:#fff;
        }

        /* DARK OVERLAY */
        .overlay {
            position:absolute;
            inset:0;
            background:rgba(0,0,0,0.45);
        }

        /* CONTENT */
        .content {
            position:relative;
            z-index:2;
            height:100%;
            display:flex;
            align-items:center;
            padding-left:8%;
            max-width:700px;
        }

        h1 {
            font-size:64px;
            letter-spacing:2px;
            margin-bottom:20px;
        }

        p {
            font-size:16px;
            opacity:.85;
            margin-bottom:30px;
            line-height:1.6;
        }

        .btn-gold {
            background:#c6a55c;
            border:none;
            color:#000;
            padding:10px 25px;
            font-weight:600;
            transition:.3s;
        }

        .btn-gold:hover {
            transform:translateY(-2px);
            opacity:.9;
        }

        .link-alt {
            color:#fff;
            text-decoration:none;
            border-bottom:1px solid #fff;
            padding-bottom:4px;
        }

        .link-alt:hover {
            opacity:.7;
        }

        @media (max-width: 768px) {
            body {
                height:auto;
                overflow:auto;
            }

            .hero {
                min-height:100vh;
                height:auto;
            }

            .content {
                padding:24px 18px;
                align-items:flex-end;
            }

            h1 {
                font-size:40px;
                line-height:1.05;
            }

            p {
                font-size:15px;
                max-width:100%;
            }

            .d-flex.gap-3 {
                flex-direction:column;
                align-items:flex-start;
            }

            .btn-gold,
            .link-alt {
                width:100%;
                text-align:center;
            }
        }

    </style>
</head>

<body>

<div class="hero">

    <div class="overlay"></div>

    <div class="content">
        <div>

            <h1>Suro Fragrance</h1>

            <p>
                Discover curated niche fragrances crafted with elegance,
                depth, and timeless character.
            </p>

            <div class="d-flex gap-3">

                <a href="/barang" class="btn btn-gold">
                    Explore Collection
                </a>

                <a href="/dashboard" class="link-alt">
                    Dashboard
                </a>

            </div>

        </div>
    </div>

</div>

</body>
</html>

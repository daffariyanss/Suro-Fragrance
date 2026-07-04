<?php helper('text'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Suro Fragrance') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root{
            --gold:#b8972a;
            --dark:#0b0b0c;
            --card:#121214;
        }

        /* BASE */
        body{
            background:var(--dark);
            color:#fff;
            font-family: 'Playfair Display', serif;
            overflow-x:hidden;
        }

        /* LOADER */
        #loader{
            position:fixed; inset:0;
            background:#000;
            display:flex; align-items:center; justify-content:center;
            z-index:9999;
            transition:.5s;
        }
        .loader-line{
            width:0; height:2px; background:var(--gold);
            animation:load 1.5s forwards;
        }
        @keyframes load{to{width:200px}}

        /* PAGE TRANSITION */
        .page{
            opacity:0;
            transform:translateY(20px);
            animation:pageIn .6s ease forwards;
        }
        @keyframes pageIn{
            to{opacity:1; transform:translateY(0)}
        }

        /* NAV */
        .navbar{
            backdrop-filter: blur(12px);
            background:rgba(0,0,0,.6);
        }

        /* BUTTON */
        .btn-gold{
            background:var(--gold);
            color:#fff;
            border:none;
        }

        /* CARD */
        .card-glass{
            background:var(--card);
            border-radius:16px;
            transition:.3s;
        }
        .card-glass:hover{
            transform:translateY(-6px) scale(1.01);
        }

        /* INPUT */
        .form-control, .form-select{
            background:#111;
            border:1px solid #333;
            color:#fff;
        }
        .form-control:focus{
            border-color:var(--gold);
            box-shadow:0 0 0 1px var(--gold);
        }

        /* FADE */
        .fade-item{
            opacity:0;
            transform:translateY(20px);
            animation:fadeUp .6s forwards;
        }
        @keyframes fadeUp{
            to{opacity:1; transform:translateY(0)}
        }

        @media (max-width: 768px){
            .page{
                padding: 0 12px;
            }
        }
    </style>
</head>

<body>

<?= $this->include('partials/loader') ?>
<?= $this->include('partials/navbar') ?>

<div class="page">
    <?= $this->renderSection('content') ?>
</div>

<script>
    window.addEventListener("load",()=>{
        document.getElementById("loader").style.opacity="0";
        setTimeout(()=>document.getElementById("loader").remove(),500);
    });
</script>

</body>
</html>

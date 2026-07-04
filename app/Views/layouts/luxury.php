<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Suro Fragrance') ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font (YSL style serif + modern sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root{
            --white:#ffffff;
            --black:#111111;
            --gray:#888;
        }

        /* BASE (BYREDO CLEAN) */
        body{
            background:#fff;
            color:#111;
            font-family:'Inter', sans-serif;
        }

        /* TYPOGRAPHY (YSL STYLE) */
        h1,h2,h3,h4,h5{
            font-family:'Playfair Display', serif;
            letter-spacing:1px;
        }

        /* NAVBAR FIX */
        .navbar{
            background:#fff !important;
            border-bottom:1px solid #eee;
        }

        /* BUTTON */
        .btn-gold{
            background:#111;
            color:#fff;
            border:none;
            transition:.3s;
        }
        .btn-gold:hover{
            background:#333;
        }

        /* CARD (BYREDO STYLE) */
        .card-lux{
            background:#fff;
            border:none;
            transition:.4s;
        }
        .card-lux:hover{
            transform:translateY(-6px);
        }

        /* IMAGE */
        .card-lux img{
            transition:.4s;
        }
        .card-lux:hover img{
            transform:scale(1.05);
        }

        /* TEXT */
        .text-muted{
            color:#777 !important;
        }

        /* DESCRIPTION */
        .desc{
            font-size:13px;
            color:#555;
            line-height:1.4;
        }

        /* ACTION BUTTON HIDDEN */
        .card-actions{
            opacity:0;
            transform:translateY(10px);
            transition:.3s;
            pointer-events:none;
        }

        .card-lux.active .card-actions{
            opacity:1;
            transform:translateY(0);
            pointer-events:auto;
        }

        /* LOADER */
        #loader{
            position:fixed;
            inset:0;
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:9999;
        }

        .loader-line{
            width:200px;
            height:2px;
            background:linear-gradient(90deg,transparent,#000,transparent);
            animation:loading 1.2s infinite;
        }

        @keyframes loading{
            0%{transform:translateX(-100%)}
            100%{transform:translateX(100%)}
        }

        /* FADE IN */
        .fade-in{
            opacity:0;
            transform:translateY(20px);
            transition:.6s ease;
        }
        .fade-in.show{
            opacity:1;
            transform:translateY(0);
        }

        @media (max-width: 768px){
            .container{
                padding-left:16px;
                padding-right:16px;
            }

            h1,h2,h3{
                letter-spacing:.5px;
            }

            .card-actions{
                opacity:1;
                transform:none;
                pointer-events:auto;
            }
        }

    </style>

</head>

<body>

<?= view('partials/loader') ?>
<?= view('partials/navbar') ?>

<?= $this->renderSection('content') ?>

<script>
    /* LOADER */
    window.addEventListener('load',()=>{
        const loader = document.getElementById('loader');
        if(loader) loader.style.display='none';
    });

    /* SCROLL ANIMATION */
    const items=document.querySelectorAll('.fade-in');
    window.addEventListener('scroll',()=>{
        items.forEach(el=>{
            const top=el.getBoundingClientRect().top;
            if(top < window.innerHeight - 100){
                el.classList.add('show');
            }
        });
    });

    /* CLICK TO TOGGLE ACTION */
    document.addEventListener('DOMContentLoaded',()=>{
        document.querySelectorAll('.card-lux').forEach(card=>{
            card.addEventListener('click',function(e){

                if(e.target.closest('.card-actions')) return;

                document.querySelectorAll('.card-lux').forEach(c=>{
                    if(c !== card) c.classList.remove('active');
                });

                card.classList.toggle('active');
            });
        });
    });
</script>

</body>
</html>

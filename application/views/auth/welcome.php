<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Our Home</title>
    <meta name="theme-color" content="#FF69B4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Bricolage+Grotesque:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;background:linear-gradient(160deg,#FF85C0,#FF69B4 40%,#FF5CA8 80%);overflow:hidden;position:relative}
        .bg-circle{position:absolute;border-radius:50%;background:rgba(255,255,255,.06)}
        .bg-circle:nth-child(1){width:300px;height:300px;top:-60px;right:-80px}
        .bg-circle:nth-child(2){width:200px;height:200px;bottom:-40px;left:-60px}
        .bg-circle:nth-child(3){width:150px;height:150px;top:40%;left:-30px}
        .splash{text-align:center;padding:2rem;animation:fadeUp .8s ease;position:relative;z-index:1}
        .logo-wrap{margin-bottom:2rem}
        .logo-wrap img{width:220px;height:220px;object-fit:contain;filter:drop-shadow(0 8px 30px rgba(0,0,0,.1));animation:float 3s ease-in-out infinite}
        .tagline{color:rgba(255,255,255,.85);font-size:.9rem;font-weight:600;margin-bottom:3rem;line-height:1.6}
        .btn-group{display:flex;flex-direction:column;gap:12px;width:100%;max-width:280px;margin:0 auto}
        .btn{display:block;font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:700;padding:14px 24px;border-radius:14px;text-align:center;text-decoration:none;transition:all .3s;cursor:pointer;border:none}
        .btn-white{background:#fff;color:#FF69B4;box-shadow:0 4px 20px rgba(0,0,0,.1)}
        .btn-white:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(0,0,0,.15)}
        .btn-outline{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.5)}
        .btn-outline:hover{background:rgba(255,255,255,.1);border-color:#fff}
        .footer-text{position:absolute;bottom:30px;color:rgba(255,255,255,.4);font-size:.7rem;font-weight:600}
        @keyframes fadeUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
    </style>
</head>
<body>
    <div class="bg-circle"></div>
    <div class="bg-circle"></div>
    <div class="bg-circle"></div>

    <div class="splash">
        <div class="logo-wrap">
            <img src="<?= base_url('assets/images/logo_ourhome.png') ?>" alt="Our Home">
        </div>
        <p class="tagline">Kelola keuangan & menu makan<br>keluarga dengan mudah 🏠</p>
        <div class="btn-group">
            <a href="<?= site_url('login') ?>" class="btn btn-white">Masuk</a>
            <a href="<?= site_url('register') ?>" class="btn btn-outline">Daftar Baru</a>
        </div>
    </div>

    <p class="footer-text">Our Home © <?= date('Y') ?></p>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Masuk — Our Home</title>
    <meta name="theme-color" content="#FF69B4">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;min-height:100vh;background:#fafaf9;display:flex;align-items:center;justify-content:center;padding:20px}
        .auth-card{width:100%;max-width:400px;animation:fadeUp .6s ease}
        .auth-header{text-align:center;margin-bottom:2rem}
        .auth-header img{width:100px;height:100px;object-fit:contain;margin-bottom:12px}
        .auth-header h1{font-size:1.5rem;font-weight:800;color:#292524;letter-spacing:-.02em}
        .auth-header p{font-size:.85rem;color:#78716c;font-weight:500;margin-top:4px}
        .auth-form{background:#fff;border-radius:20px;padding:28px 24px;box-shadow:0 8px 40px rgba(0,0,0,.06);border:1px solid #f5f5f4}
        .form-group{margin-bottom:16px}
        .form-group label{display:block;font-size:.78rem;font-weight:700;color:#57534e;margin-bottom:6px}
        .form-group input{width:100%;font-family:'DM Sans',sans-serif;font-size:.9rem;padding:12px 14px;border:1.5px solid #e7e5e4;border-radius:12px;background:#fafaf9;transition:all .2s;color:#292524}
        .form-group input:focus{outline:none;border-color:#FF69B4;background:#fff;box-shadow:0 0 0 3px rgba(255,105,180,.1)}
        .form-group input::placeholder{color:#a8a29e}
        .btn{width:100%;font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:700;padding:14px;border-radius:14px;border:none;cursor:pointer;transition:all .3s;text-align:center}
        .btn-pink{background:linear-gradient(135deg,#FF85C0,#FF69B4);color:#fff;box-shadow:0 4px 16px rgba(255,105,180,.25)}
        .btn-pink:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,105,180,.35)}
        .error-box{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:10px 14px;border-radius:10px;font-size:.82rem;font-weight:600;margin-bottom:16px;text-align:center}
        .auth-footer{text-align:center;margin-top:20px;font-size:.82rem;color:#78716c;font-weight:500}
        .auth-footer a{color:#FF69B4;font-weight:700;text-decoration:none}
        .auth-footer a:hover{text-decoration:underline}
        .back-link{display:inline-flex;align-items:center;gap:4px;font-size:.82rem;font-weight:600;color:#78716c;text-decoration:none;margin-bottom:16px}
        .back-link:hover{color:#FF69B4}
        .divider{display:flex;align-items:center;gap:10px;margin:16px 0;font-size:.75rem;color:#a8a29e;font-weight:600}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:#e7e5e4}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    </style>
</head>
<body>
    <div class="auth-card">
        <a href="<?= site_url('welcome') ?>" class="back-link">← Kembali</a>

        <div class="auth-header">
            <img src="<?= base_url('assets/images/logo_ourhome.png') ?>" alt="Our Home">
            <h1>Selamat Datang!</h1>
            <p>Masuk ke akun kamu</p>
        </div>

        <div class="auth-form">
            <?php if (!empty($error)): ?>
                <div class="error-box">⚠️ <?= $error ?></div>
            <?php endif; ?>

            <form action="<?= site_url('auth/login') ?>" method="POST">
                <div class="form-group">
                    <label>📧 Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com" autocomplete="email" autofocus>
                </div>
                <div class="form-group">
                    <label>🔒 Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password" autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-pink">Masuk →</button>
            </form>
        </div>

        <div class="auth-footer">
            Belum punya akun? <a href="<?= site_url('register') ?>">Daftar Sekarang</a>
        </div>
    </div>
</body>
</html>

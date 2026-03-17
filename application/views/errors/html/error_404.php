<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>404 - Halaman Tidak Ditemukan</title>
<style>
    body{font-family:'DM Sans',-apple-system,sans-serif;background:#f5f5f4;color:#292524;padding:40px 20px;text-align:center}
    .box{max-width:500px;margin:0 auto;background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06);border:1px solid #e7e5e4}
    .icon{font-size:3rem;margin-bottom:10px}
    h1{color:#d97706;font-size:1.4rem;margin-bottom:12px}
    p{color:#57534e;font-size:.9rem}
    a{color:#e85d26;text-decoration:none;font-weight:600}
</style>
</head>
<body>
    <div class="box">
        <div class="icon">🍽️</div>
        <h1><?php echo $heading; ?></h1>
        <?php echo $message; ?>
        <p style="margin-top:16px"><a href="/">← Kembali ke Dashboard</a></p>
    </div>
</body>
</html>

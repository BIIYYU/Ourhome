<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Database Error</title>
<style>
    body{font-family:'DM Sans',-apple-system,sans-serif;background:#f5f5f4;color:#292524;padding:40px 20px;text-align:center}
    .box{max-width:600px;margin:0 auto;background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06);border:1px solid #e7e5e4}
    h1{color:#dc2626;font-size:1.4rem;margin-bottom:12px}
    p{color:#57534e;font-size:.9rem;line-height:1.6;text-align:left}
</style>
</head>
<body>
    <div class="box">
        <h1><?php echo $heading; ?></h1>
        <?php echo $message; ?>
    </div>
</body>
</html>

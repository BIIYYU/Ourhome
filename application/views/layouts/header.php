<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Our Home'; ?></title>
    <meta name="theme-color" content="#e8608c">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo_ourhome.png') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        :root{
            --brand:#e8608c;--brand-light:#fff0f4;--brand-dark:#d14a76;--brand-glow:rgba(232,96,140,.12);
            --green:#2dbe6e;--green-soft:#edfcf2;--red:#ef4466;--red-soft:#fff0f2;
            --amber:#f2a735;--amber-soft:#fef8ec;--sky:#3ba4e8;--sky-soft:#eef7ff;
            --purple:#9b6dd7;--purple-soft:#f5f0ff;
            --rose-50:#fff5f7;--rose-100:#ffe8ed;--rose-200:#ffd1db;--rose-300:#ffadbf;
            --stone-50:#fdfcfb;--stone-100:#f8f6f4;--stone-200:#efe9e5;--stone-300:#e0d8d2;
            --stone-400:#b5aaa2;--stone-500:#8a7e77;--stone-600:#66594f;--stone-700:#4a3f38;--stone-800:#332a25;--stone-900:#1f1915;
            --radius:16px;--radius-sm:12px;--radius-xs:8px;
            --shadow:0 1px 4px rgba(140,80,100,.04),0 4px 16px rgba(140,80,100,.06);
            --shadow-lg:0 8px 32px rgba(140,80,100,.1);--shadow-pink:0 4px 20px rgba(232,96,140,.12);
            --font:'Nunito',-apple-system,sans-serif;--font-display:'Playfair Display',Georgia,serif;
            --ease:cubic-bezier(.4,0,.2,1);
        }
        body{font-family:var(--font);background:#f8f4f1;color:var(--stone-800);min-height:100vh}

        /* ── TOPBAR ── */
        .topbar{
            background:#fff;border-bottom:1px solid var(--rose-100);
            position:sticky;top:0;z-index:100;
            box-shadow:0 1px 8px rgba(140,80,100,.04);
        }
        .topbar-inner{
            max-width:1200px;margin:0 auto;
            display:flex;align-items:center;height:60px;padding:0 28px;gap:8px;
        }
        .tb-logo{display:flex;align-items:center;gap:9px;text-decoration:none;margin-right:24px;flex-shrink:0}
        .tb-logo img{width:34px;height:34px;object-fit:contain;border-radius:9px}
        .tb-logo span{font-family:var(--font-display);font-weight:800;font-size:1.2rem;color:var(--brand-dark)}

        /* Nav links */
        .tb-nav{display:flex;align-items:center;gap:2px;flex:1}
        .tb-link{
            display:flex;align-items:center;gap:6px;
            padding:8px 14px;border-radius:var(--radius-xs);
            text-decoration:none;color:var(--stone-500);
            font-size:.84rem;font-weight:700;
            transition:all .2s;white-space:nowrap;position:relative;
        }
        .tb-link:hover{background:var(--brand-light);color:var(--brand)}
        .tb-link.active{background:var(--brand);color:#fff}
        .tb-link.active:hover{background:var(--brand-dark)}
        .tb-link .tl-icon{font-size:1rem}

        /* More dropdown */
        .tb-more{position:relative}
        .tb-more-btn{
            display:flex;align-items:center;gap:5px;
            padding:8px 12px;border-radius:var(--radius-xs);
            border:none;background:none;cursor:pointer;
            color:var(--stone-500);font-size:.84rem;font-weight:700;
            font-family:var(--font);transition:all .2s;
        }
        .tb-more-btn:hover{background:var(--brand-light);color:var(--brand)}
        .tb-more-btn.open{background:var(--brand-light);color:var(--brand)}
        .tb-dropdown{
            position:absolute;top:calc(100% + 6px);right:0;
            background:#fff;border:1px solid var(--rose-100);border-radius:var(--radius-sm);
            box-shadow:var(--shadow-lg);min-width:200px;
            display:none;z-index:200;overflow:hidden;
        }
        .tb-dropdown.open{display:block;animation:fadeUp .2s var(--ease)}
        .td-item{
            display:flex;align-items:center;gap:10px;
            padding:11px 16px;font-size:.84rem;font-weight:600;
            color:var(--stone-600);text-decoration:none;
            transition:all .15s;
        }
        .td-item:hover{background:var(--brand-light);color:var(--brand)}
        .td-item.active{background:var(--brand-light);color:var(--brand);font-weight:700}
        .td-item .tdi{font-size:1.05rem;width:22px;text-align:center}
        .td-divider{height:1px;background:var(--rose-100);margin:4px 0}

        /* User section */
        .tb-user{display:flex;align-items:center;gap:8px;margin-left:auto;position:relative;flex-shrink:0}
        .tb-avatar{
            width:36px;height:36px;border-radius:50%;
            background:linear-gradient(135deg,var(--rose-200),var(--brand-light));
            display:flex;align-items:center;justify-content:center;
            font-size:.72rem;font-weight:800;color:var(--brand);
            cursor:pointer;transition:all .2s;border:2px solid var(--rose-100);
        }
        .tb-avatar:hover{border-color:var(--brand);transform:scale(1.05)}
        .tb-uname{font-size:.8rem;font-weight:700;color:var(--stone-600);cursor:pointer;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .tb-udrop{
            position:absolute;top:calc(100% + 6px);right:0;
            background:#fff;border:1px solid var(--rose-100);border-radius:var(--radius-sm);
            box-shadow:var(--shadow-lg);min-width:200px;
            display:none;z-index:200;overflow:hidden;
        }
        .tb-udrop.open{display:block;animation:fadeUp .2s var(--ease)}
        .tbu-header{padding:14px 16px;border-bottom:1px solid var(--rose-100);background:var(--rose-50)}
        .tbu-header .tbu-name{font-size:.88rem;font-weight:800;color:var(--stone-800)}
        .tbu-header .tbu-email{font-size:.7rem;color:var(--stone-400);font-weight:500}

        /* ── CONTENT ── */
        .app-container{max-width:960px;margin:0 auto;padding:28px 32px}
        .page-header{margin-bottom:24px}
        .page-header h1{font-family:var(--font);font-size:1.6rem;font-weight:900;letter-spacing:-.02em;color:var(--stone-800)}
        .page-header p{font-size:.85rem;color:var(--stone-400);margin-top:3px;font-weight:600}

        /* CARD */
        .mp-card{background:#fff;border:1px solid var(--rose-100);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;transition:all .3s var(--ease)}
        .mp-card:hover{box-shadow:var(--shadow-lg)}
        .mp-card-body{padding:1.2rem 1.4rem}
        .mp-card-header{padding:1rem 1.4rem;border-bottom:1px solid var(--rose-100);display:flex;align-items:center;justify-content:space-between}
        .mp-card-header h3{font-size:.95rem;font-weight:800;display:flex;align-items:center;gap:6px}

        /* BUTTONS */
        .btn-mp{font-family:var(--font);font-size:.85rem;font-weight:700;padding:10px 20px;border-radius:var(--radius-xs);border:1.5px solid transparent;cursor:pointer;transition:all .2s var(--ease);display:inline-flex;align-items:center;gap:6px}
        .btn-mp:hover{transform:translateY(-1px);box-shadow:var(--shadow-pink)}.btn-mp:active{transform:translateY(0)}
        .btn-brand{background:linear-gradient(135deg,#f078a0,var(--brand));color:#fff;border-color:transparent}
        .btn-brand:hover{background:linear-gradient(135deg,var(--brand),var(--brand-dark))}
        .btn-outline{background:#fff;color:var(--stone-600);border-color:var(--rose-200)}
        .btn-outline:hover{border-color:var(--brand);color:var(--brand);background:var(--brand-light)}
        .btn-green{background:var(--green);color:#fff}
        .btn-ghost{background:transparent;border:none;color:var(--stone-400);padding:6px 10px}
        .btn-ghost:hover{color:var(--brand);background:var(--brand-light)}
        .btn-sm{font-size:.78rem;padding:7px 14px}

        /* FORM */
        .form-group{margin-bottom:16px}
        .form-group label{display:block;font-size:.8rem;font-weight:700;color:var(--stone-500);margin-bottom:6px}
        .form-input{width:100%;font-family:var(--font);font-size:.9rem;padding:11px 14px;border:1.5px solid var(--rose-200);border-radius:var(--radius-xs);background:#fff;color:var(--stone-800);transition:all .2s}
        .form-input:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px var(--brand-glow);background:var(--rose-50)}
        select.form-input{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23b5aaa2' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px}

        /* BADGE */
        .badge{font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:20px;display:inline-block}
        .badge-brand{background:var(--brand-light);color:var(--brand)}
        .badge-green{background:var(--green-soft);color:var(--green)}
        .badge-red{background:var(--red-soft);color:var(--red)}
        .badge-amber{background:var(--amber-soft);color:var(--amber)}

        /* TOAST */
        .toast-success{position:fixed;top:72px;right:32px;background:linear-gradient(135deg,#42d392,var(--green));color:#fff;padding:12px 24px;border-radius:var(--radius-sm);font-size:.88rem;font-weight:700;box-shadow:0 8px 24px rgba(45,190,110,.2);z-index:9999;animation:slideIn .4s var(--ease),fadeOut .4s var(--ease) 2.5s forwards}
        @keyframes slideIn{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
        @keyframes fadeOut{to{opacity:0;transform:translateX(40px)}}

        /* UTILS */
        .text-brand{color:var(--brand)}.text-green{color:var(--green)}.text-red{color:var(--red)}.text-muted{color:var(--stone-400)}
        .fw-800{font-weight:800}.fs-sm{font-size:.8rem}.fs-xs{font-size:.7rem}
        .mt-1{margin-top:8px}.mt-2{margin-top:16px}.mb-1{margin-bottom:8px}.mb-2{margin-bottom:16px}
        .gap-1{gap:8px}.gap-2{gap:16px}.d-flex{display:flex}.flex-wrap{flex-wrap:wrap}
        .items-center{align-items:center}.justify-between{justify-content:space-between}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}
        .grid-4{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:14px}
        .w-full{width:100%}.text-center{text-align:center}.text-right{text-align:right}
        .rupiah::before{content:'Rp';font-size:.75em;opacity:.7;margin-right:2px}
        @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
        .anim-up{animation:fadeUp .5s var(--ease) both}
        .anim-up-1{animation-delay:.05s}.anim-up-2{animation-delay:.1s}.anim-up-3{animation-delay:.15s}.anim-up-4{animation-delay:.2s}
    </style>
</head>
<body>

<?php
$t = $title ?? '';
$nama = $this->session->userdata('nama_user') ?: 'User';
$email = $this->session->userdata('email') ?: '';
$initials = strtoupper(substr($nama, 0, 1));
$ww = explode(' ', $nama);
if (count($ww) > 1) $initials .= strtoupper(substr(end($ww), 0, 1));
?>

<div class="topbar">
    <div class="topbar-inner">
        <!-- Logo -->
        <a href="<?= site_url('laporan') ?>" class="tb-logo">
            <img src="<?= base_url('assets/images/logo_ourhome.png') ?>" alt="Our Home">
            <span>Our Home</span>
        </a>

        <!-- Nav -->
        <nav class="tb-nav">
            <a href="<?= site_url('laporan') ?>" class="tb-link <?= $t=='Home'?'active':'' ?>">
                <span class="tl-icon">🏠</span> Home
            </a>
            <a href="<?= site_url('rencana') ?>" class="tb-link <?= $t=='Rencana Makan'?'active':'' ?>">
                <span class="tl-icon">📅</span> Menu Mingguan
            </a>
            <a href="<?= site_url('belanja') ?>" class="tb-link <?= $t=='Daftar Belanja'?'active':'' ?>">
                <span class="tl-icon">🛒</span> Belanja
            </a>
            <a href="<?= site_url('dapur') ?>" class="tb-link <?= $t=='Dapur'?'active':'' ?>">
                <span class="tl-icon">🍽️</span> Dapur
            </a>

            <!-- More dropdown -->
            <div class="tb-more">
                <button class="tb-more-btn" id="moreBtn" onclick="document.getElementById('moreDrop').classList.toggle('open');this.classList.toggle('open')">
                    <span class="tl-icon">•••</span> Lainnya ▾
                </button>
                <div class="tb-dropdown" id="moreDrop">
                    <a href="<?= site_url('pemasukan') ?>" class="td-item <?= $t=='Pemasukan'?'active':'' ?>">
                        <span class="tdi">💰</span> Pemasukan
                    </a>
                    <a href="<?= site_url('resep') ?>" class="td-item <?= $t=='Database Resep'?'active':'' ?>">
                        <span class="tdi">📖</span> Resep
                    </a>
                    <a href="<?= site_url('master-harga') ?>" class="td-item <?= $t=='Master Harga'?'active':'' ?>">
                        <span class="tdi">🏷️</span> Harga Bahan
                    </a>
                    <div class="td-divider"></div>
                    <a href="<?= site_url('setup') ?>" class="td-item <?= $t=='Setup'?'active':'' ?>">
                        <span class="tdi">⚙️</span> Pengaturan
                    </a>
                </div>
            </div>
        </nav>

        <!-- User -->
        <div class="tb-user" id="userToggle" onclick="document.getElementById('userDrop').classList.toggle('open')">
            <span class="tb-uname"><?= htmlspecialchars($nama) ?></span>
            <div class="tb-avatar"><?= $initials ?></div>
            <div class="tb-udrop" id="userDrop">
                <div class="tbu-header">
                    <div class="tbu-name"><?= htmlspecialchars($nama) ?></div>
                    <div class="tbu-email"><?= htmlspecialchars($email) ?></div>
                </div>
                <a href="<?= site_url('setup') ?>" class="td-item"><span class="tdi">⚙️</span> Pengaturan</a>
                <div class="td-divider"></div>
                <a href="<?= site_url('logout') ?>" class="td-item" style="color:var(--red)" onclick="return confirm('Yakin mau logout?')"><span class="tdi">🚪</span> Keluar</a>
            </div>
        </div>
    </div>
</div>

<script>
// Close dropdowns on outside click
document.addEventListener('click', function(e) {
    var ud = document.getElementById('userDrop'), ut = document.getElementById('userToggle');
    if (ud && !ut.contains(e.target)) ud.classList.remove('open');
    var md = document.getElementById('moreDrop'), mb = document.getElementById('moreBtn');
    if (md && !mb.contains(e.target) && !md.contains(e.target)) { md.classList.remove('open'); mb.classList.remove('open'); }
});
</script>

<?php if($this->session->flashdata('success')):?><div class="toast-success"><?=$this->session->flashdata('success')?></div><?php endif;?>

<div class="app-container">

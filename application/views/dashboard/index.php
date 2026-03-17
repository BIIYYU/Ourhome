<!-- DASHBOARD -->
<div class="page-header">
    <p class="fs-sm text-muted">Selamat datang kembali 👋</p>
    <h1>Dashboard</h1>
</div>

<!-- Budget Overview -->
<div class="mp-card anim-up mb-2" style="background:linear-gradient(135deg, var(--brand), #ff78d4); border:none; color:#fff;">
    <div class="mp-card-body" style="padding:1.5rem">
        <div class="d-flex justify-between items-center" style="margin-bottom:16px">
            <div>
                <p style="font-size:.72rem; font-weight:600; opacity:.7; text-transform:uppercase; letter-spacing:.06em;">Budget Minggu Ini</p>
                <p style="font-family:var(--font-display); font-size:2rem; font-weight:800; letter-spacing:-.03em;">
                    <?= 'Rp' . number_format($budget->budget_amount, 0, ',', '.') ?>
                </p>
                <a href="<?= site_url('setup') ?>" style="font-size:.68rem; font-weight:600; color:rgba(255,255,255,.7); text-decoration:underline;">Ubah Budget →</a>
            </div>
            <div style="text-align:right">
                <div style="width:60px; height:60px; border-radius:50%; border:4px solid rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; position:relative;">
                    <svg width="60" height="60" viewBox="0 0 60 60" style="position:absolute; transform:rotate(-90deg)">
                        <circle cx="30" cy="30" r="26" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="4" />
                        <circle cx="30" cy="30" r="26" fill="none" stroke="#fff" stroke-width="4" stroke-dasharray="<?= round(163.36 * min($persen_budget, 100) / 100) ?> 163.36" stroke-linecap="round" />
                    </svg>
                    <span style="font-size:.82rem; font-weight:800; position:relative; z-index:1;"><?= $persen_budget ?>%</span>
                </div>
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px;">
            <div style="background:rgba(255,255,255,.15); border-radius:10px; padding:8px 12px;">
                <p style="font-size:.6rem; opacity:.7; font-weight:600;">🛒 Belanja</p>
                <p style="font-size:.95rem; font-weight:800;"><?= 'Rp' . number_format($terpakai, 0, ',', '.') ?></p>
            </div>
            <div style="background:rgba(255,255,255,.2); border-radius:10px; padding:8px 12px;">
                <p style="font-size:.6rem; opacity:.7; font-weight:600;">💰 Sisa Budget</p>
                <p style="font-size:.95rem; font-weight:800; <?= $sisa < 0 ? 'color:#fca5a5;' : '' ?>"><?= 'Rp' . number_format(abs($sisa), 0, ',', '.') ?><?= $sisa < 0 ? ' ⚠️' : '' ?></p>
            </div>
            <div style="background:rgba(255,255,255,.1); border-radius:10px; padding:8px 12px; border:1px dashed rgba(255,255,255,.2);">
                <p style="font-size:.6rem; opacity:.5; font-weight:600;">📅 Simulasi Menu</p>
                <p style="font-size:.95rem; font-weight:800; opacity:.7;"><?= 'Rp' . number_format($estimasi_menu ?? 0, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid-2 mb-2">
    <div class="mp-card anim-up anim-up-1">
        <div class="mp-card-body text-center" style="padding:1.2rem">
            <div style="width:44px;height:44px;background:var(--sky-soft);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;font-size:1.2rem;">
                📅
            </div>
            <p style="font-size:1.4rem; font-weight:800; color:var(--stone-900);"><?= $slot_terisi ?>/<?= $total_slot ?></p>
            <p class="fs-xs text-muted" style="font-weight:600;">Menu Terisi</p>
        </div>
    </div>
    <a href="<?= site_url('rencana') ?>" style="text-decoration:none;">
        <div class="mp-card anim-up anim-up-2">
            <div class="mp-card-body text-center" style="padding:1.2rem">
                <div style="width:44px;height:44px;background:var(--brand-light);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;font-size:1.2rem;">
                    🤖
                </div>
                <p style="font-size:.85rem; font-weight:700; color:var(--brand);">Rekomendasi</p>
                <p class="fs-xs text-muted" style="font-weight:600;">Auto Generate Menu</p>
            </div>
        </div>
    </a>
</div>

<!-- Menu Hari Ini -->
<div class="mp-card anim-up anim-up-3 mb-2">
    <div class="mp-card-header">
        <h3>🍳 Menu Hari Ini</h3>
        <span class="badge badge-brand"><?= date('l, d M') ?></span>
    </div>
    <div class="mp-card-body">
        <?php
        $jadwal_today = array_values($jadwal_hari_ini);
        $waktu_labels = ['pagi' => '☀️ Pagi', 'siang' => '🌤️ Siang', 'malam' => '🌙 Malam'];
        if (empty($jadwal_today)) : ?>
            <div class="text-center" style="padding:1.5rem 0;">
                <p style="font-size:2rem; margin-bottom:8px;">📝</p>
                <p class="text-muted fs-sm" style="font-weight:600;">Belum ada menu hari ini</p>
                <a href="<?= site_url('rencana') ?>" class="btn-mp btn-brand btn-sm mt-1">Buat Jadwal</a>
            </div>
        <?php else : ?>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <?php foreach ($jadwal_today as $j) : ?>
                    <div style="display:flex; align-items:center; gap:10px; padding:8px 12px; background:var(--stone-50); border-radius:var(--radius-xs);">
                        <span style="font-size:.85rem;"><?= $waktu_labels[$j->waktu_makan] ?? '🍽️' ?></span>
                        <div style="flex:1;">
                            <p style="font-size:.88rem; font-weight:700;"><?= htmlspecialchars($j->nama_resep ?: $j->nama_custom) ?></p>
                        </div>
                        <?php if ($j->estimasi_harga) : ?>
                            <span class="fs-xs text-muted" style="font-weight:600;">Rp<?= number_format($j->estimasi_harga, 0, ',', '.') ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pengeluaran by Kategori -->
<?php if (!empty($by_kategori)) : ?>
    <div class="mp-card anim-up anim-up-4 mb-2">
        <div class="mp-card-header">
            <h3>💰 Pengeluaran per Kategori</h3>
        </div>
        <div class="mp-card-body">
            <?php foreach ($by_kategori as $kat) : ?>
                <?php $pct = $terpakai > 0 ? round(($kat->total / $terpakai) * 100) : 0; ?>
                <div style="margin-bottom:10px;">
                    <div class="d-flex justify-between items-center mb-1">
                        <span style="font-size:.82rem; font-weight:600; text-transform:capitalize;"><?= htmlspecialchars($kat->kategori ?: 'Lainnya') ?></span>
                        <span class="fs-sm fw-800"><?= 'Rp' . number_format($kat->total, 0, ',', '.') ?></span>
                    </div>
                    <div style="height:6px; background:var(--stone-100); border-radius:3px; overflow:hidden;">
                        <div style="width:<?= $pct ?>%; height:100%; background:var(--brand); border-radius:3px; transition:width .6s var(--ease);"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- End of dashboard content -->
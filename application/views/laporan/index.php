<!-- LAPORAN - 3 Tab -->
<style>
    .filter-bar {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .filter-bar select {
        font-family: var(--font);
        font-size: .85rem;
        font-weight: 600;
        padding: 8px 12px;
        border: 1.5px solid var(--stone-200);
        border-radius: 8px;
        background: #fff;
        color: var(--stone-700);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2378716c' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 30px;
    }

    .filter-bar select:focus {
        outline: none;
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(232, 96, 140, .08);
    }

    .month-pills {
        display: flex;
        gap: 4px;
        overflow-x: auto;
        padding-bottom: 4px;
        flex: 1;
    }

    .month-pills::-webkit-scrollbar {
        height: 3px;
    }

    .mpill {
        font-family: var(--font);
        font-size: .72rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 16px;
        border: 1.5px solid var(--stone-200);
        background: #fff;
        color: var(--stone-500);
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
        transition: all .2s;
    }

    .mpill:hover {
        border-color: var(--brand);
        color: var(--brand);
    }

    .mpill.active {
        background: var(--brand);
        color: #fff;
        border-color: var(--brand);
    }

    .tab-bar {
        display: flex;
        background: #fff;
        border: 1px solid var(--stone-200);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .tab-btn {
        flex: 1;
        padding: 10px 8px;
        text-align: center;
        font-family: var(--font);
        font-size: .72rem;
        font-weight: 700;
        background: #fff;
        border: none;
        color: var(--stone-400);
        cursor: pointer;
        transition: all .2s;
        border-bottom: 3px solid transparent;
    }

    .tab-btn:hover {
        background: var(--stone-50);
        color: var(--stone-600);
    }

    .tab-btn.active {
        color: var(--brand);
        border-bottom-color: var(--brand);
        background: var(--brand-light);
    }

    .tab-btn .ti {
        font-size: 1rem;
        display: block;
        margin-bottom: 2px;
    }

    .tc {
        display: none;
    }

    .tc.active {
        display: block;
    }

    .sg {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 10px;
        margin-bottom: 16px;
    }

    .sc {
        background: #fff;
        border: 1px solid var(--stone-200);
        border-radius: var(--radius);
        padding: 14px 16px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .sc::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
    }

    .sc-o::before {
        background: var(--brand);
    }

    .sc-g::before {
        background: var(--green);
    }

    .sc-r::before {
        background: var(--red);
    }

    .sc-b::before {
        background: var(--sky);
    }

    .sc-p::before {
        background: var(--purple);
    }

    .sc-y::before {
        background: var(--amber);
    }

    .sc-n::before {
        background: var(--stone-300);
    }

    .sc-l {
        font-size: .63rem;
        font-weight: 700;
        color: var(--stone-400);
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 4px;
    }

    .sc-v {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--stone-800);
    }

    .kr {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .ki {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        flex-shrink: 0;
    }

    .kn {
        font-size: .82rem;
        font-weight: 700;
        color: var(--stone-700);
    }

    .kbb {
        height: 6px;
        background: var(--stone-100);
        border-radius: 3px;
        overflow: hidden;
        margin-top: 3px;
    }

    .kbf {
        height: 100%;
        border-radius: 3px;
        transition: width .6s var(--ease);
    }

    .dc {
        display: flex;
        align-items: flex-end;
        gap: 3px;
        height: 120px;
        padding: 0 2px;
    }

    .db {
        flex: 1;
        min-width: 4px;
        border-radius: 2px 2px 0 0;
        transition: height .5s var(--ease);
        cursor: default;
        position: relative;
    }

    .db:hover {
        opacity: .8;
    }

    .db:hover::after {
        content: attr(data-tip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: var(--stone-800);
        color: #fff;
        font-size: .6rem;
        font-weight: 600;
        padding: 3px 6px;
        border-radius: 4px;
        white-space: nowrap;
        margin-bottom: 4px;
    }

    .dl {
        font-size: .5rem;
        color: var(--stone-400);
        text-align: center;
        font-weight: 600;
        margin-top: 2px;
    }

    .wr {
        padding: 12px 16px;
        border-bottom: 1px solid var(--stone-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .wr:last-child {
        border-bottom: none;
    }

    .wr:hover {
        background: var(--stone-50);
    }

    .saldo-card {
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
    }

    .saldo-pos {
        background: linear-gradient(135deg, #FF9CE0, #FF4D7C);
        color: #fff;
    }

    .saldo-neg {
        background: linear-gradient(135deg, #ef4466, #d93452);
        color: #fff;
    }

    .saldo-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-top: 12px;
    }

    .saldo-box {
        background: rgba(255, 255, 255, .15);
        border-radius: 10px;
        padding: 8px 12px;
    }

    .saldo-box .sb-l {
        font-size: .6rem;
        opacity: .7;
        font-weight: 600;
    }

    .saldo-box .sb-v {
        font-size: .92rem;
        font-weight: 800;
    }
</style>

<?php
$nama_bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
$kat_ic = ['lauk' => ['🍗', '#fef2f2', '#dc2626'], 'sayur' => ['🥬', '#f0fdf4', '#16a34a'], 'bumbu' => ['🧂', '#fffbeb', '#d97706'], 'bahan_pokok' => ['🍚', '#f0f9ff', '#0284c7'], 'snack' => ['🍿', '#fefce8', '#a16207'], 'protein' => ['🍗', '#fef2f2', '#dc2626'], 'minyak' => ['🫗', '#fefce8', '#a16207'], 'lainnya' => ['📦', '#f5f5f4', '#78716c']];
$r = $ringkasan;
$s = $saldo;
$tab = $active_tab;
$bl = $bl_total;
?>

<div style="margin-bottom:14px;display:flex;justify-content:space-between;align-items:flex-start">
    <div>
        <h1 style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; letter-spacing:-.03em;">🏠 Home</h1>
        <p class="fs-sm text-muted">Ringkasan Keuangan — <?= $nama_bulan[$bulan] ?> <?= $tahun ?></p>
    </div>
    <a href="<?= site_url('export-laporan?bulan=' . $bulan . '&tahun=' . $tahun) ?>" target="_blank" class="btn-mp btn-outline btn-sm" style="font-size:.7rem" title="Export PDF">📥 Export PDF</a>
</div>

<!-- FITUR 6: Budget Alerts -->
<?php if (!empty($alerts)) : ?>
    <div class="anim-up" style="margin-bottom:14px">
        <?php foreach ($alerts as $al) : ?>
            <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:<?= $al->pct >= 100 ? 'var(--red-soft)' : 'var(--amber-soft)' ?>;border:1px solid <?= $al->pct >= 100 ? '#fca5a540' : '#f2a73540' ?>;border-radius:10px;margin-bottom:6px">
                <span style="font-size:1.1rem"><?= $al->pct >= 100 ? '🚨' : '⚠️' ?></span>
                <p style="font-size:.8rem;font-weight:700;color:<?= $al->pct >= 100 ? 'var(--red)' : 'var(--amber)' ?>;flex:1"><?= $al->msg ?></p>
                <span style="font-size:.7rem;font-weight:800;color:<?= $al->pct >= 100 ? 'var(--red)' : 'var(--amber)' ?>"><?= $al->pct ?>%</span>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- FITUR 1: Tren 3 Bulan -->
<?php if (!empty($tren)) : ?>
    <div class="mp-card anim-up mb-2">
        <div class="mp-card-header">
            <h3 style="font-size:.88rem">📈 Tren 3 Bulan Terakhir</h3>
        </div>
        <div class="mp-card-body" style="padding:20px 24px">
            <?php
            $max_tren = max(array_map(fn ($t) => max($t->total_keluar, $t->pemasukan), $tren)) ?: 1;
            $is_last = count($tren) - 1;
            ?>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px">
                <?php foreach ($tren as $idx => $ti) :
                    $pct_m = round($ti->pemasukan / $max_tren * 100);
                    $pct_k = round($ti->total_keluar / $max_tren * 100);
                    $sisa_bln = $ti->pemasukan - $ti->total_keluar;
                    $is_cur = ($idx == $is_last);
                ?>
                    <div style="background:<?= $is_cur ? 'linear-gradient(135deg, var(--brand-light), var(--rose-50))' : 'var(--stone-50)' ?>;border-radius:14px;padding:16px 12px;text-align:center;border:1.5px solid <?= $is_cur ? 'var(--rose-200)' : 'transparent' ?>;position:relative;transition:all .3s">
                        <?php if ($is_cur) : ?><span style="position:absolute;top:8px;right:8px;font-size:.5rem;font-weight:800;background:var(--brand);color:#fff;padding:2px 6px;border-radius:4px">AKTIF</span><?php endif; ?>
                        <p style="font-size:.75rem;font-weight:800;color:var(--stone-700);margin-bottom:12px"><?= $nama_bulan[$ti->bulan] ?></p>

                        <!-- Bars -->
                        <div style="height:120px;display:flex;align-items:flex-end;justify-content:center;gap:8px;margin-bottom:10px;position:relative">
                            <!-- Grid lines -->
                            <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:space-between;pointer-events:none">
                                <?php for ($g = 0; $g < 4; $g++) : ?><div style="border-bottom:1px dashed var(--stone-200);height:0"></div><?php endfor; ?>
                            </div>
                            <!-- Pemasukan bar -->
                            <div style="position:relative;z-index:1;width:32px">
                                <div style="height:<?= max(6, round($pct_m * 1.1)) ?>px;background:linear-gradient(180deg,#34d399,#10b981);border-radius:6px 6px 3px 3px;box-shadow:0 2px 8px rgba(16,185,129,.25);position:relative;transition:height .6s ease <?= $idx * .15 ?>s">
                                    <?php if ($ti->pemasukan > 0) : ?>
                                        <span style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:.55rem;font-weight:800;color:var(--green);white-space:nowrap"><?= number_format($ti->pemasukan / 1000, 0) ?>k</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Pengeluaran bar -->
                            <div style="position:relative;z-index:1;width:32px">
                                <div style="height:<?= max(6, round($pct_k * 1.1)) ?>px;background:linear-gradient(180deg,#f78da7,var(--brand));border-radius:6px 6px 3px 3px;box-shadow:0 2px 8px rgba(232,96,140,.25);position:relative;transition:height .6s ease <?= $idx * .15 + .1 ?>s">
                                    <?php if ($ti->total_keluar > 0) : ?>
                                        <span style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:.55rem;font-weight:800;color:var(--brand);white-space:nowrap"><?= number_format($ti->total_keluar / 1000, 0) ?>k</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Saldo pill -->
                        <div style="display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:20px;background:<?= $sisa_bln >= 0 ? 'var(--green-soft)' : 'var(--red-soft)' ?>">
                            <span style="font-size:.65rem"><?= $sisa_bln >= 0 ? '📈' : '📉' ?></span>
                            <span style="font-size:.72rem;font-weight:800;color:<?= $sisa_bln >= 0 ? 'var(--green)' : 'var(--red)' ?>"><?= $sisa_bln >= 0 ? '+' : '' ?>Rp<?= number_format($sisa_bln / 1000, 0) ?>k</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Legend -->
            <div style="display:flex;gap:20px;justify-content:center;font-size:.72rem;font-weight:700">
                <span style="display:flex;align-items:center;gap:5px"><span style="width:12px;height:12px;background:linear-gradient(180deg,#34d399,#10b981);border-radius:3px;display:inline-block"></span><span style="color:var(--stone-500)">Pemasukan</span></span>
                <span style="display:flex;align-items:center;gap:5px"><span style="width:12px;height:12px;background:linear-gradient(180deg,#f78da7,var(--brand));border-radius:3px;display:inline-block"></span><span style="color:var(--stone-500)">Pengeluaran</span></span>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- FITUR 7: Target Tabungan -->
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3 style="font-size:.88rem">🐷 Tabungan</h3>
        <button class="btn-mp btn-outline btn-sm" onclick="openTabunganModal()" style="font-size:.65rem;padding:3px 8px">+ Target</button>
    </div>
    <div class="mp-card-body">
        <div style="display:flex;align-items:center;gap:12px;padding:12px 16px;background:var(--green-soft);border-radius:12px;margin-bottom:12px">
            <span style="font-size:1.5rem">💰</span>
            <div style="flex:1">
                <p style="font-size:.68rem;font-weight:700;color:var(--green)">Total Sisa dari Semua Bulan</p>
                <p style="font-size:1.2rem;font-weight:900;color:var(--stone-800)">Rp<?= number_format($total_sisa_all, 0, ',', '.') ?></p>
            </div>
        </div>
        <?php if (!empty($tabungan)) : ?>
            <?php foreach ($tabungan as $tb) :
                $pct_tab = (float)$tb->target_amount > 0 ? min(100, round($total_sisa_all / (float)$tb->target_amount * 100)) : 0;
            ?>
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--rose-100)" id="tab-<?= $tb->id ?>">
                    <span style="font-size:1.1rem">🎯</span>
                    <div style="flex:1">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px">
                            <span style="font-size:.82rem;font-weight:700"><?= htmlspecialchars($tb->nama_target) ?></span>
                            <span style="font-size:.7rem;font-weight:800;color:<?= $pct_tab >= 100 ? 'var(--green)' : 'var(--brand)' ?>"><?= $pct_tab ?>%</span>
                        </div>
                        <div style="height:6px;background:var(--stone-100);border-radius:3px;overflow:hidden">
                            <div style="height:100%;width:<?= $pct_tab ?>%;background:<?= $pct_tab >= 100 ? 'var(--green)' : 'var(--brand)' ?>;border-radius:3px;transition:width .5s"></div>
                        </div>
                        <p style="font-size:.6rem;font-weight:600;color:var(--stone-400);margin-top:3px">Target: Rp<?= number_format($tb->target_amount, 0, ',', '.') ?><?= $pct_tab >= 100 ? ' ✅ Tercapai!' : '' ?></p>
                    </div>
                    <button onclick="hapusTabungan(<?= $tb->id ?>)" style="background:none;border:none;cursor:pointer;font-size:.65rem;color:var(--stone-300);padding:4px" title="Hapus">🗑</button>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p style="font-size:.82rem;color:var(--stone-400);text-align:center;padding:8px 0">Belum ada target. Tambah target tabungan untuk tracking.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Tambah Target Tabungan -->
<div class="mo" id="addTabungan" style="position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:500;display:none;backdrop-filter:blur(4px)">
    <div style="background:#fff;border-radius:var(--radius);box-shadow:0 24px 80px rgba(0,0,0,.15);width:100%;max-width:380px;overflow:hidden;margin:auto">
        <div style="padding:14px 18px;border-bottom:1px solid var(--rose-100);display:flex;justify-content:space-between;align-items:center">
            <h4 style="font-size:.92rem;font-weight:800">🎯 Target Tabungan Baru</h4>
            <button onclick="closeTabunganModal()" style="background:var(--stone-100);border:none;width:30px;height:30px;border-radius:8px;font-size:1.1rem;cursor:pointer">&times;</button>
        </div>
        <div style="padding:16px 18px">
            <div class="form-group"><label>Nama Target</label><input type="text" id="tabNama" class="form-input" placeholder="cth: Dana Darurat, Liburan"></div>
            <div class="form-group"><label>Target (Rp)</label><input type="number" id="tabAmount" class="form-input" placeholder="5000000" min="0" step="100000"></div>
            <button onclick="saveTabungan()" class="btn-mp btn-brand w-full" style="justify-content:center">💾 Simpan</button>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="filter-bar">
    <div class="month-pills">
        <?php for ($i = 0; $i < 12; $i++) : $dt = strtotime("-{$i} months");
            $m = (int)date('m', $dt);
            $y = (int)date('Y', $dt);
            $ac = ($m == $bulan && $y == $tahun); ?>
            <a href="<?= site_url('laporan?bulan=' . $m . '&tahun=' . $y . '&tab=' . $tab) ?>" class="mpill <?= $ac ? 'active' : '' ?>"><?= substr($nama_bulan[$m], 0, 3) ?> <?= substr($y, 2) ?></a>
        <?php endfor; ?>
    </div>
    <form method="get" action="<?= site_url('laporan') ?>" style="display:flex;gap:4px;">
        <input type="hidden" name="tab" value="<?= $tab ?>">
        <select name="bulan"><?php for ($m = 1; $m <= 12; $m++) : ?><option value="<?= $m ?>" <?= $m == $bulan ? 'selected' : '' ?>><?= $nama_bulan[$m] ?></option><?php endfor; ?></select>
        <select name="tahun"><?php for ($y = (int)date('Y'); $y >= 2024; $y--) : ?><option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option><?php endfor; ?></select>
        <button type="submit" class="btn-mp btn-brand btn-sm">Lihat</button>
    </form>
</div>

<!-- TABS -->
<div class="tab-bar anim-up">
    <button class="tab-btn <?= $tab == 'saldo' ? 'active' : '' ?>" onclick="switchTab('saldo')"><span class="ti">💰</span>Saldo & Pemasukan</button>
    <button class="tab-btn <?= $tab == 'makan' ? 'active' : '' ?>" onclick="switchTab('makan')"><span class="ti">🍽️</span>Pengeluaran Dapur</button>
    <button class="tab-btn <?= $tab == 'belanja' ? 'active' : '' ?>" onclick="switchTab('belanja')"><span class="ti">🛒</span>Belanja</button>
</div>

<!-- ===== TAB: SALDO & PEMASUKAN ===== -->
<div class="tc <?= $tab == 'saldo' ? 'active' : '' ?>" id="tab-saldo">
    <div class="saldo-card <?= $s['saldo'] >= 0 ? 'saldo-pos' : 'saldo-neg' ?> anim-up">
        <div class="d-flex justify-between items-center">
            <div>
                <p style="font-size:.7rem; opacity:.7; font-weight:600;"><?= $s['saldo'] >= 0 ? '✅ Sisa Saldo Bulan Ini' : '⚠️ Minus Bulan Ini' ?></p>
                <p style="font-size:1.8rem; font-weight:800;">Rp<?= number_format(abs($s['saldo']), 0, ',', '.') ?></p>
            </div>
            <a href="<?= site_url('pemasukan?bulan=' . $bulan . '&tahun=' . $tahun) ?>" style="font-size:.7rem; color:rgba(255,255,255,.8); font-weight:600; text-decoration:underline;">Kelola Pemasukan →</a>
        </div>
        <div class="saldo-grid">
            <div class="saldo-box">
                <p class="sb-l">💰 Pemasukan</p>
                <p class="sb-v">Rp<?= number_format($s['total_pemasukan'], 0, ',', '.') ?></p>
            </div>
            <div class="saldo-box">
                <p class="sb-l">🍽️ Dapur</p>
                <p class="sb-v">Rp<?= number_format($s['total_dapur'], 0, ',', '.') ?></p>
            </div>
            <div class="saldo-box">
                <p class="sb-l">🛒 Belanja</p>
                <p class="sb-v">Rp<?= number_format($s['total_belanja'], 0, ',', '.') ?></p>
            </div>
            <div class="saldo-box">
                <p class="sb-l">💸 Lain-lain</p>
                <p class="sb-v">Rp<?= number_format($s['total_lain'] ?? 0, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <!-- Breakdown visual -->
    <?php if ($s['total_pemasukan'] > 0) :
        $pct_d = round($s['total_dapur'] / $s['total_pemasukan'] * 100);
        $pct_b = round($s['total_belanja'] / $s['total_pemasukan'] * 100);
        $pct_l = round(($s['total_lain'] ?? 0) / $s['total_pemasukan'] * 100);
        $pct_s = max(0, 100 - $pct_d - $pct_b - $pct_l);
    ?>
        <div class="mp-card anim-up mb-2">
            <div class="mp-card-header">
                <h3 style="font-size:.88rem;">📊 Distribusi Keuangan</h3>
            </div>
            <div class="mp-card-body">
                <!-- Stacked bar -->
                <div style="display:flex; height:24px; border-radius:6px; overflow:hidden; margin-bottom:12px;">
                    <?php if ($pct_d > 0) : ?><div style="width:<?= $pct_d ?>%; background:var(--brand);" title="Dapur <?= $pct_d ?>%"></div><?php endif; ?>
                    <?php if ($pct_b > 0) : ?><div style="width:<?= $pct_b ?>%; background:var(--amber);" title="Belanja <?= $pct_b ?>%"></div><?php endif; ?>
                    <?php if ($pct_l > 0) : ?><div style="width:<?= $pct_l ?>%; background:var(--purple);" title="Lain-lain <?= $pct_l ?>%"></div><?php endif; ?>
                    <?php if ($pct_s > 0) : ?><div style="width:<?= $pct_s ?>%; background:var(--green);" title="Sisa <?= $pct_s ?>%"></div><?php endif; ?>
                </div>
                <div style="display:flex; gap:12px; flex-wrap:wrap; font-size:.75rem; font-weight:600;">
                    <span style="color:var(--brand);">🟠 Dapur <?= $pct_d ?>%</span>
                    <span style="color:var(--amber);">🟡 Belanja <?= $pct_b ?>%</span>
                    <span style="color:var(--purple);">🟣 Lain-lain <?= $pct_l ?>%</span>
                    <span style="color:var(--green);">🟢 Sisa <?= $pct_s ?>%</span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Pemasukan per sumber -->
    <?php if (!empty($s['per_sumber'])) : ?>
        <div class="mp-card anim-up mb-2">
            <div class="mp-card-header">
                <h3 style="font-size:.88rem;">💰 Pemasukan per Sumber</h3>
            </div>
            <div class="mp-card-body">
                <?php foreach ($s['per_sumber'] as $ps) : $pct = $s['total_pemasukan'] > 0 ? round($ps->total / $s['total_pemasukan'] * 100) : 0; ?>
                    <div class="kr">
                        <div class="ki" style="background:var(--green-soft)">💰</div>
                        <div style="flex:1">
                            <div class="kn"><?= htmlspecialchars($ps->sumber) ?> <span style="font-size:.6rem;color:var(--stone-400)"><?= $pct ?>%</span></div>
                            <div class="kbb">
                                <div class="kbf" style="width:<?= $pct ?>%;background:var(--green)"></div>
                            </div>
                        </div>
                        <div style="text-align:right"><span style="font-size:.82rem;font-weight:800;color:var(--stone-700)">Rp<?= number_format($ps->total, 0, ',', '.') ?></span><br><span style="font-size:.6rem;color:var(--stone-400);font-weight:600"><?= $ps->kali ?>x</span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($s['total_pemasukan'] == 0) : ?>
        <div class="mp-card anim-up mb-2">
            <div class="mp-card-body text-center" style="padding:2rem">
                <p style="font-size:2.5rem;margin-bottom:6px">💰</p>
                <p style="font-weight:700;color:var(--stone-600);margin-bottom:4px">Belum ada pemasukan bulan ini</p><a href="<?= site_url('pemasukan?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn-mp btn-brand btn-sm mt-1">➕ Tambah Pemasukan</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Pengeluaran Lain per Kategori -->
    <?php if (!empty($s['lain_per_kat'])) : ?>
        <div class="mp-card anim-up mb-2">
            <div class="mp-card-header">
                <h3 style="font-size:.88rem;">💸 Pengeluaran Lain per Kategori</h3>
            </div>
            <div class="mp-card-body">
                <?php
                $kat_lain_ic = ['tagihan' => ['💡', '#fef2f2', '#dc2626'], 'asuransi' => ['🛡️', '#f0f9ff', '#0284c7'], 'peralatan' => ['🔧', '#f5f3ff', '#7c3aed'], 'transportasi' => ['🚗', '#fefce8', '#a16207'], 'pendidikan' => ['📚', '#f0fdf4', '#16a34a'], 'kesehatan' => ['🏥', '#f0f9ff', '#0284c7'], 'hiburan' => ['🎬', '#fef2f2', '#dc2626'], 'lainnya' => ['📦', '#f5f5f4', '#78716c']];
                foreach ($s['lain_per_kat'] as $lk) :
                    $lki = $kat_lain_ic[$lk->kategori ?? 'lainnya'] ?? $kat_lain_ic['lainnya'];
                    $lpct = ($s['total_lain'] ?? 0) > 0 ? round($lk->total / $s['total_lain'] * 100) : 0;
                ?>
                    <div class="kr">
                        <div class="ki" style="background:<?= $lki[1] ?>"><?= $lki[0] ?></div>
                        <div style="flex:1">
                            <div class="kn"><?= ucfirst($lk->kategori ?? 'Lainnya') ?> <span style="font-size:.6rem;color:var(--stone-400)"><?= $lpct ?>%</span></div>
                            <div class="kbb">
                                <div class="kbf" style="width:<?= $lpct ?>%;background:<?= $lki[2] ?>"></div>
                            </div>
                        </div>
                        <div style="text-align:right"><span style="font-size:.82rem;font-weight:800;color:var(--stone-700)">Rp<?= number_format($lk->total, 0, ',', '.') ?></span><br><span style="font-size:.6rem;color:var(--stone-400);font-weight:600"><?= $lk->jumlah ?>x</span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- ===== TAB: PENGELUARAN DAPUR ===== -->
<div class="tc <?= $tab == 'makan' ? 'active' : '' ?>" id="tab-makan">
    <?php $sm = $r['total_budget'] - $r['total'];
    $om = $sm < 0;
    $rm = $r['transaksi'] > 0 ? $r['total'] / max(1, date('j', strtotime($r['tgl_akhir']))) : 0; ?>
    <div class="sg anim-up">
        <div class="sc sc-n">
            <p class="sc-l">🏦 Budget</p>
            <p class="sc-v">Rp<?= number_format($r['total_budget'], 0, ',', '.') ?></p>
        </div>
        <div class="sc sc-o">
            <p class="sc-l">🍽️ Pengeluaran</p>
            <p class="sc-v" style="color:var(--brand)">Rp<?= number_format($r['total'], 0, ',', '.') ?></p>
        </div>
        <div class="sc <?= $om ? 'sc-r' : 'sc-g' ?>">
            <p class="sc-l"><?= $om ? '⚠️ Over' : '💰 Sisa' ?></p>
            <p class="sc-v" style="color:<?= $om ? 'var(--red)' : 'var(--green)' ?>">Rp<?= number_format(abs($sm), 0, ',', '.') ?></p>
        </div>
        <div class="sc sc-b">
            <p class="sc-l">📋 Transaksi</p>
            <p class="sc-v"><?= $r['transaksi'] ?> kali</p>
        </div>
        <div class="sc sc-p">
            <p class="sc-l">📈 Rata²/Hari</p>
            <p class="sc-v">Rp<?= number_format($rm, 0, ',', '.') ?></p>
        </div>
    </div>
    <?php if (!empty($r['per_kategori'])) : ?><div class="mp-card anim-up mb-2">
            <div class="mp-card-header">
                <h3 style="font-size:.88rem">🍽️ Per Kategori</h3>
            </div>
            <div class="mp-card-body"><?php foreach ($r['per_kategori'] as $k) : $ki = $kat_ic[$k->kategori ?? 'lainnya'] ?? $kat_ic['lainnya'];
                                            $p = $r['total'] > 0 ? round($k->total / $r['total'] * 100) : 0; ?><div class="kr">
                        <div class="ki" style="background:<?= $ki[1] ?>"><?= $ki[0] ?></div>
                        <div style="flex:1">
                            <div class="kn"><?= ucfirst($k->kategori ?? 'Lainnya') ?> <span style="font-size:.6rem;color:var(--stone-400)"><?= $p ?>%</span></div>
                            <div class="kbb">
                                <div class="kbf" style="width:<?= $p ?>%;background:<?= $ki[2] ?>"></div>
                            </div>
                        </div>
                        <div style="text-align:right"><span style="font-size:.82rem;font-weight:800;color:var(--stone-700)">Rp<?= number_format($k->total, 0, ',', '.') ?></span><br><span style="font-size:.6rem;color:var(--stone-400);font-weight:600"><?= $k->jumlah ?>x</span></div>
                    </div><?php endforeach; ?></div>
        </div><?php endif; ?>
    <?php if (!empty($r['per_hari'])) : ?><div class="mp-card anim-up mb-2">
            <div class="mp-card-header">
                <h3 style="font-size:.88rem">📈 Harian</h3>
            </div>
            <div class="mp-card-body"><?php $mx = 0;
                                        foreach ($r['per_hari'] as $d) $mx = max($mx, (float)$d->total);
                                        $dim = (int)date('t', strtotime($r['tgl_awal']));
                                        $dm = [];
                                        foreach ($r['per_hari'] as $d) $dm[date('j', strtotime($d->tanggal))] = (float)$d->total; ?><div class="dc"><?php for ($d = 1; $d <= $dim; $d++) : $v = $dm[$d] ?? 0;
                                                                                                                                                        $h = $mx > 0 ? max(2, round($v / $mx * 110)) : 2;
                                                                                                                                                        $c = $v > 0 ? 'var(--brand)' : 'var(--stone-100)';
                                                                                                                                                        $it = ($d == (int)date('j') && $bulan == (int)date('m') && $tahun == (int)date('Y')); ?><div style="flex:1;display:flex;flex-direction:column;align-items:center">
                            <div class="db" style="height:<?= $h ?>px;background:<?= $it ? 'var(--sky)' : $c ?>;width:100%" data-tip="Tgl <?= $d ?>: Rp<?= number_format($v, 0, ',', '.') ?>"></div><?php if ($d % 5 == 1 || $d == $dim) : ?><span class="dl"><?= $d ?></span><?php endif; ?>
                        </div><?php endfor; ?></div>
            </div>
        </div><?php endif; ?>
    <div class="mp-card anim-up mb-2">
        <div class="mp-card-header">
            <h3 style="font-size:.88rem">📋 Per Minggu</h3><span class="badge badge-brand"><?= count($laporan) ?></span>
        </div><?php if (empty($laporan)) : ?><div class="mp-card-body text-center" style="padding:2rem">
                <p style="font-size:2rem;margin-bottom:6px">📭</p>
                <p style="font-weight:600;color:var(--stone-400)">Belum ada data</p>
            </div><?php else : ?><div style="padding:0"><?php foreach ($laporan as $l) : $sw = $l->budget_amount - $l->total_belanja;
                                                            $pc = $l->budget_amount > 0 ? round($l->total_belanja / $l->budget_amount * 100) : 0;
                                                            $ov = $sw < 0; ?><div class="wr">
                        <div>
                            <p style="font-size:.85rem;font-weight:700;color:var(--stone-800)">Minggu <?= $l->minggu_ke ?></p>
                            <p style="font-size:.68rem;color:var(--stone-400);font-weight:600"><?= date('d M', strtotime($l->tanggal_mulai)) ?> — <?= date('d M', strtotime($l->tanggal_selesai)) ?></p>
                            <div style="height:4px;background:var(--stone-100);border-radius:2px;overflow:hidden;margin-top:6px;width:120px">
                                <div style="width:<?= min($pc, 100) ?>%;height:100%;border-radius:2px;background:<?= $ov ? 'var(--red)' : ($pc > 80 ? 'var(--amber)' : 'var(--green)') ?>"></div>
                            </div>
                        </div>
                        <div style="text-align:right">
                            <p style="font-size:.95rem;font-weight:800;color:<?= $ov ? 'var(--red)' : 'var(--green)' ?>">Rp<?= number_format($l->total_belanja, 0, ',', '.') ?></p>
                            <p style="font-size:.65rem;font-weight:600;color:<?= $ov ? 'var(--red)' : 'var(--stone-400)' ?>"><?= $ov ? 'Over' : 'Sisa' ?> Rp<?= number_format(abs($sw), 0, ',', '.') ?></p>
                        </div>
                    </div><?php endforeach; ?></div><?php endif; ?>
    </div>
</div>

<!-- ===== TAB: BELANJA BULANAN ===== -->
<div class="tc <?= $tab == 'belanja' ? 'active' : '' ?>" id="tab-belanja">
    <div class="sg anim-up">
        <div class="sc sc-y">
            <p class="sc-l">🛒 Total Estimasi</p>
            <p class="sc-v" style="color:var(--amber)">Rp<?= number_format($bl->total ?? 0, 0, ',', '.') ?></p>
        </div>
        <div class="sc sc-g">
            <p class="sc-l">✅ Sudah Beli</p>
            <p class="sc-v" style="color:var(--green)">Rp<?= number_format($bl->total_sudah ?? 0, 0, ',', '.') ?></p>
        </div>
        <div class="sc sc-b">
            <p class="sc-l">📦 Item</p>
            <p class="sc-v"><?= $bl->total_item ?? 0 ?></p>
        </div>
        <div class="sc sc-p">
            <p class="sc-l">✅ Progress</p>
            <p class="sc-v"><?= ($bl->total_item ?? 0) > 0 ? round(($bl->sudah_beli ?? 0) / ($bl->total_item) * 100) : 0 ?>%</p>
        </div>
    </div>
    <?php if (!empty($belanja_per_kat)) : ?><div class="mp-card anim-up mb-2">
            <div class="mp-card-header">
                <h3 style="font-size:.88rem">🛒 Per Kategori</h3>
            </div>
            <div class="mp-card-body"><?php $bt = (float)($bl->total ?? 1);
                                        foreach ($belanja_per_kat as $k) : $ki = $kat_ic[$k->kategori ?? 'lainnya'] ?? $kat_ic['lainnya'];
                                            $p = $bt > 0 ? round($k->total / $bt * 100) : 0; ?><div class="kr">
                        <div class="ki" style="background:<?= $ki[1] ?>"><?= $ki[0] ?></div>
                        <div style="flex:1">
                            <div class="kn"><?= ucfirst($k->kategori ?? 'Lainnya') ?> <span style="font-size:.6rem;color:var(--stone-400)"><?= $p ?>%</span></div>
                            <div class="kbb">
                                <div class="kbf" style="width:<?= $p ?>%;background:<?= $ki[2] ?>"></div>
                            </div>
                        </div>
                        <div style="text-align:right"><span style="font-size:.82rem;font-weight:800;color:var(--stone-700)">Rp<?= number_format($k->total, 0, ',', '.') ?></span><br><span style="font-size:.6rem;color:var(--stone-400);font-weight:600"><?= $k->sudah ?>/<?= $k->jumlah ?> item</span></div>
                    </div><?php endforeach; ?></div>
        </div><?php endif; ?>
    <?php if (($bl->total_item ?? 0) == 0) : ?><div class="mp-card anim-up mb-2">
            <div class="mp-card-body text-center" style="padding:2rem">
                <p style="font-size:2.5rem;margin-bottom:6px">🛒</p>
                <p style="font-weight:700;color:var(--stone-600)">Belum ada data belanja</p><a href="<?= site_url('belanja') ?>" class="btn-mp btn-brand btn-sm mt-1">🛒 Ke Belanja</a>
            </div>
        </div><?php endif; ?>
</div>

<!-- Nav -->
<div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;margin-top:8px;">
    <?php $pm = $bulan - 1;
    $py = $tahun;
    if ($pm < 1) {
        $pm = 12;
        $py--;
    }
    $nm = $bulan + 1;
    $ny = $tahun;
    if ($nm > 12) {
        $nm = 1;
        $ny++;
    } ?>
    <a href="<?= site_url('laporan?bulan=' . $pm . '&tahun=' . $py . '&tab=' . $tab) ?>" class="btn-mp btn-outline btn-sm">← <?= substr($nama_bulan[$pm], 0, 3) ?> <?= $py ?></a>
    <a href="<?= site_url('laporan?bulan=' . date('m') . '&tahun=' . date('Y') . '&tab=' . $tab) ?>" class="btn-mp btn-brand btn-sm">Bulan Ini</a>
    <a href="<?= site_url('laporan?bulan=' . $nm . '&tahun=' . $ny . '&tab=' . $tab) ?>" class="btn-mp btn-outline btn-sm"><?= substr($nama_bulan[$nm], 0, 3) ?> <?= $ny ?> →</a>
</div>
<script>
    function switchTab(t) {
        document.querySelectorAll('.tab-btn').forEach(function(b) {
            b.classList.remove('active')
        });
        document.querySelectorAll('.tc').forEach(function(c) {
            c.classList.remove('active')
        });
        document.getElementById('tab-' + t).classList.add('active');
        event.target.closest('.tab-btn').classList.add('active');
        var u = new URL(window.location);
        u.searchParams.set('tab', t);
        history.replaceState(null, '', u);
    }

    function openTabunganModal() {
        document.getElementById('addTabungan').style.display = 'flex'
    }

    function closeTabunganModal() {
        document.getElementById('addTabungan').style.display = 'none'
    }
    document.getElementById('addTabungan').addEventListener('click', function(e) {
        if (e.target === this) closeTabunganModal()
    });

    function saveTabungan() {
        var n = document.getElementById('tabNama').value || 'Tabungan';
        var a = document.getElementById('tabAmount').value || 0;
        $.post('<?= site_url("tabungan/save") ?>', {
            nama_target: n,
            target_amount: a
        }, function() {
            location.reload()
        }, 'json');
    }

    function hapusTabungan(id) {
        if (!confirm('Hapus target ini?')) return;
        $.post('<?= site_url("tabungan/delete") ?>', {
            id: id
        }, function() {
            location.reload()
        }, 'json');
    }
</script>
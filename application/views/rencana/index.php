<!-- Menu Mingguan - Full CRUD -->
<style>
    .wn-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .wn-btns {
        display: flex;
        gap: 4px;
    }

    .wn-btn {
        font-family: var(--font);
        font-size: .78rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 8px;
        border: 1.5px solid var(--stone-200);
        background: #fff;
        color: var(--stone-600);
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .wn-btn:hover {
        border-color: var(--brand);
        color: var(--brand);
        background: var(--brand-light);
    }

    .wn-btn.wn-active {
        background: var(--brand);
        color: #fff;
        border-color: var(--brand);
    }

    .ss {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        padding: 12px 16px;
        background: #fff;
        border: 1px solid var(--stone-200);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 16px;
    }

    .ss-i {
        font-size: .75rem;
        font-weight: 600;
        color: var(--stone-500);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .ss-i strong {
        color: var(--stone-800);
    }

    .dc {
        background: #fff;
        border: 1px solid var(--stone-200);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 12px;
    }

    .dc.dc-today {
        border: 2px solid var(--brand);
    }

    .dc.dc-today .dc-h {
        background: linear-gradient(135deg, #f078a0, var(--brand));
    }

    .dc.dc-today .dc-h,
    .dc.dc-today .dc-h * {
        color: #fff !important;
    }

    .dc.dc-past {
        opacity: .7;
    }

    .dc-h {
        padding: 10px 16px;
        background: var(--stone-50);
        border-bottom: 1px solid var(--stone-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dc-h-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dc-day {
        font-size: .95rem;
        font-weight: 800;
        color: var(--stone-800);
    }

    .dc-date {
        font-size: .7rem;
        font-weight: 600;
        color: var(--stone-400);
    }

    .dc-badge {
        font-size: .55rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .25);
    }

    .dc-total {
        font-size: .72rem;
        font-weight: 700;
        color: var(--brand);
    }

    /* Meal row */
    .mr {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-bottom: 1px solid var(--stone-50);
        transition: background .15s;
    }

    .mr:last-child {
        border-bottom: none;
    }

    .mr:hover {
        background: var(--stone-50);
    }

    .mr-time {
        width: 52px;
        flex-shrink: 0;
        text-align: center;
    }

    .mr-time .ti {
        font-size: .95rem;
    }

    .mr-time .tl {
        font-size: .55rem;
        font-weight: 700;
        color: var(--stone-400);
        text-transform: uppercase;
    }

    .mr-info {
        flex: 1;
        min-width: 0;
    }

    .mr-name {
        font-size: .85rem;
        font-weight: 700;
        color: var(--stone-800);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .mr-meta {
        font-size: .65rem;
        color: var(--stone-400);
        font-weight: 600;
        display: flex;
        gap: 6px;
        margin-top: 1px;
    }

    .mr-price {
        font-size: .8rem;
        font-weight: 800;
        color: var(--brand);
        white-space: nowrap;
    }

    .mr-acts {
        display: flex;
        gap: 3px;
        opacity: 0;
        transition: opacity .2s;
    }

    .mr:hover .mr-acts {
        opacity: 1;
    }

    .mr-btn {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: .65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
        background: var(--stone-100);
        color: var(--stone-500);
    }

    .mr-btn:hover {
        background: var(--brand-light);
        color: var(--brand);
    }

    .mr-btn.mr-del:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Empty slot - clickable */
    .mr-empty {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-bottom: 1px solid var(--stone-50);
        cursor: pointer;
        transition: background .15s;
    }

    .mr-empty:hover {
        background: var(--brand-light);
    }

    .mr-empty:last-child {
        border-bottom: none;
    }

    .mr-empty .me-label {
        font-size: .78rem;
        color: var(--stone-300);
        font-weight: 600;
    }

    .mr-empty:hover .me-label {
        color: var(--brand);
    }

    .mr-slot {
        border-bottom: 1px solid var(--stone-100);
    }

    .mr-slot:last-child {
        border-bottom: none;
    }

    .mr-add:hover {
        background: var(--brand-light);
    }

    .mr-add:hover span {
        color: var(--brand) !important;
    }

    /* Modal */
    .mo {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 500;
        display: none;
        backdrop-filter: blur(4px);
    }

    .mo.open {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .mo-box {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: 0 24px 80px rgba(0, 0, 0, .15);
        width: 100%;
        max-width: 440px;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        animation: fadeUp .3s var(--ease);
        overflow: hidden;
    }

    .mo-head {
        padding: 12px 16px;
        border-bottom: 1px solid var(--stone-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .mo-head h4 {
        font-size: .9rem;
        font-weight: 700;
    }

    .mo-head .mo-sub {
        font-size: .7rem;
        color: var(--stone-400);
        font-weight: 600;
    }

    .mo-x {
        background: var(--stone-50);
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        color: var(--stone-400);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mo-x:hover {
        background: var(--stone-200);
    }

    .mo-body {
        padding: 12px 16px;
        overflow-y: auto;
        flex: 1;
    }

    .mo-foot {
        padding: 10px 16px;
        border-top: 1px solid var(--stone-100);
        background: var(--stone-50);
    }

    .mo-search {
        position: relative;
        margin-bottom: 8px;
    }

    .mo-search input {
        width: 100%;
        font-family: var(--font);
        font-size: .85rem;
        padding: 8px 12px 8px 32px;
        border: 1.5px solid var(--stone-200);
        border-radius: 8px;
        background: var(--stone-50);
    }

    .mo-search input:focus {
        outline: none;
        border-color: var(--brand);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(232, 96, 140, .08);
    }

    .mo-search .mo-si {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: .8rem;
    }

    .mo-pills {
        display: flex;
        gap: 3px;
        flex-wrap: wrap;
        margin-bottom: 8px;
    }

    .mo-pill {
        font-size: .65rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 12px;
        border: 1px solid var(--stone-200);
        background: #fff;
        color: var(--stone-500);
        cursor: pointer;
        transition: all .15s;
    }

    .mo-pill:hover {
        border-color: var(--brand);
        color: var(--brand);
    }

    .mo-pill.on {
        background: var(--brand);
        color: #fff;
        border-color: var(--brand);
    }

    .rp {
        padding: 7px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: all .12s;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 2px;
    }

    .rp:hover {
        background: var(--brand-light);
    }

    .rp:active {
        transform: scale(.98);
    }

    .rp-ic {
        font-size: 1.1rem;
        width: 30px;
        height: 30px;
        background: var(--stone-50);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .rp-nm {
        font-size: .8rem;
        font-weight: 700;
        color: var(--stone-800);
    }

    .rp-sub {
        font-size: .62rem;
        color: var(--stone-400);
        font-weight: 600;
        display: flex;
        gap: 6px;
    }

    .toast {
        position: fixed;
        top: 70px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--brand);
        color: #fff;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: .82rem;
        font-weight: 600;
        z-index: 9999;
        display: none;
        box-shadow: 0 8px 24px rgba(232, 96, 140, .25);
    }

    .toast.show {
        display: block;
        animation: fadeUp .3s var(--ease);
    }
</style>

<?php
$hari_indo = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 0 => 'Minggu'];
$waktu_info = ['pagi' => ['i' => '☀️', 'l' => 'Pagi'], 'siang' => ['i' => '🌤️', 'l' => 'Siang'], 'malam' => ['i' => '🌙', 'l' => 'Malam']];
$frekuensi = (int)($settings->frekuensi_makan ?? 3);
$waktu_keys = $frekuensi == 2 ? ['pagi', 'malam'] : ['pagi', 'siang', 'malam'];
$budget_amt = (float)($budget->budget_amount ?? $settings->budget_mingguan ?? 300000);
$is_past_week = ($week_offset < 0);
?>

<!-- Header -->
<div class="wn-bar">
    <div>
        <h1 style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; letter-spacing:-.03em;">
            🍽️ Menu Mingguan
        </h1>
        <p class="fs-sm text-muted">
            <?= date('d M', strtotime($senin)) ?> — <?= date('d M Y', strtotime($minggu_end)) ?>
            <?php if ($is_past_week) : ?><span style="color:var(--stone-400);">(history)</span><?php endif; ?>
        </p>
    </div>
    <div class="wn-btns">
        <a href="<?= site_url('rencana?week=' . ($week_offset - 1)) ?>" class="wn-btn">←</a>
        <a href="<?= site_url('rencana?week=' . ($week_offset - 1)) ?>" class="wn-btn" style="font-size:.68rem;">Minggu Lalu</a>
        <a href="<?= site_url('rencana?week=0') ?>" class="wn-btn <?= $week_offset == 0 ? 'wn-active' : '' ?>">Minggu Ini</a>
        <a href="<?= site_url('rencana?week=' . ($week_offset + 1)) ?>" class="wn-btn" style="font-size:.68rem;">Minggu Depan</a>
        <a href="<?= site_url('rencana?week=' . ($week_offset + 1)) ?>" class="wn-btn">→</a>
    </div>
</div>

<!-- Toolbar -->
<div style="display:flex; gap:6px; margin-bottom:14px; flex-wrap:wrap;">
    <button class="btn-mp btn-outline btn-sm" id="btnCopy" onclick="copyMingguLalu()">
        📋 Copy Minggu Lalu
    </button>
    <button class="btn-mp btn-brand btn-sm" id="btnRekom" onclick="rekomendasi()">
        🤖 Rekomendasi Otomatis
    </button>
    <a href="<?= site_url('resep') ?>" class="btn-mp btn-outline btn-sm">📖 Resep</a>
</div>

<!-- Summary -->
<div class="ss anim-up" id="summaryStrip">
    <div class="ss-i">📊 Terisi: <strong id="ssCount"><?= $total_jadwal ?>/<?= 7 * count($waktu_keys) ?></strong></div>
    <div class="ss-i">💰 Simulasi: <strong style="color:var(--brand)" id="ssEst">Rp<?= number_format($total_est, 0, ',', '.') ?></strong></div>
    <div class="ss-i">🏦 Budget: <strong>Rp<?= number_format($budget_amt, 0, ',', '.') ?></strong></div>
    <?php $sisa = $budget_amt - $total_est; ?>
    <div class="ss-i"><?= $sisa >= 0 ? '✅' : '⚠️' ?> Sisa: <strong style="color:<?= $sisa >= 0 ? 'var(--green)' : 'var(--red)' ?>" id="ssSisa">Rp<?= number_format(abs($sisa), 0, ',', '.') ?><?= $sisa < 0 ? ' over' : '' ?></strong></div>
</div>

<!-- Day Cards -->
<?php foreach ($hari_list as $tgl => $meals) :
    $is_today = ($tgl == date('Y-m-d'));
    $is_past = ($tgl < date('Y-m-d'));
    $day_num = date('w', strtotime($tgl));
    $day_name = $hari_indo[$day_num] ?? '';
    $day_total = 0;
    foreach ($meals as $m) $day_total += (float)($m->estimasi_harga ?? 0);
    // Group by waktu_makan as ARRAYS
    $meal_map = [];
    foreach ($meals as $m) {
        if (!isset($meal_map[$m->waktu_makan])) $meal_map[$m->waktu_makan] = [];
        $meal_map[$m->waktu_makan][] = $m;
    }
?>
    <div class="dc anim-up <?= $is_today ? 'dc-today' : '' ?> <?= $is_past && !$is_today ? 'dc-past' : '' ?>" id="day-<?= $tgl ?>">
        <div class="dc-h">
            <div class="dc-h-left">
                <span class="dc-day"><?= $day_name ?></span>
                <span class="dc-date"><?= date('d M Y', strtotime($tgl)) ?></span>
                <?php if ($is_today) : ?><span class="dc-badge">HARI INI</span><?php endif; ?>
            </div>
            <span class="dc-total" id="total-<?= $tgl ?>"><?= $day_total > 0 ? 'Rp' . number_format($day_total, 0, ',', '.') : '' ?></span>
        </div>
        <div class="dc-body" id="body-<?= $tgl ?>">
            <?php foreach ($waktu_keys as $wk) :
                $w = $waktu_info[$wk];
                $items = $meal_map[$wk] ?? [];
                $slot_total = 0;
                foreach ($items as $mi) $slot_total += (float)($mi->estimasi_harga ?? 0);
            ?>
                <div class="mr-slot" id="slot-<?= $tgl ?>-<?= $wk ?>">
                    <!-- Waktu header -->
                    <div style="display:flex; align-items:center; gap:8px; padding:6px 16px 2px; <?= empty($items) ? '' : 'border-top:1px solid var(--stone-50);' ?>">
                        <div class="mr-time"><span class="ti"><?= $w['i'] ?></span><br><span class="tl"><?= $w['l'] ?></span></div>
                        <?php if (count($items) > 1) : ?>
                            <span style="font-size:.6rem; font-weight:700; color:var(--stone-400); margin-left:auto;"><?= count($items) ?> menu · Rp<?= number_format($slot_total, 0, ',', '.') ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($items)) : ?>
                        <?php foreach ($items as $idx => $m) : ?>
                            <div class="mr" id="mr-<?= $m->id_jadwal ?>" style="padding-left:68px;">
                                <div class="mr-info">
                                    <div class="mr-name"><span><?= $m->icon ?? '🍽️' ?></span> <?= htmlspecialchars($m->nama_resep ?: $m->nama_custom ?: '-') ?></div>
                                    <div class="mr-meta">
                                        <?php if (!empty($m->nama_kategori)) : ?><span><?= $m->nama_kategori ?></span><?php endif; ?>
                                        <?php if (!empty($m->waktu_masak)) : ?><span>⏱<?= $m->waktu_masak ?>m</span><?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($m->estimasi_harga > 0) : ?>
                                    <span class="mr-price">Rp<?= number_format($m->estimasi_harga, 0, ',', '.') ?></span>
                                <?php endif; ?>
                                <div class="mr-acts">
                                    <button class="mr-btn mr-del" onclick="hapus(<?= $m->id_jadwal ?>)" title="Hapus">🗑</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Tambah lauk button (selalu muncul) -->
                    <div class="mr-add" onclick="openPick('<?= $tgl ?>','<?= $wk ?>','<?= $day_name ?>')" style="padding-left:68px; padding:5px 16px 5px 68px; cursor:pointer; transition:background .15s;">
                        <span style="font-size:.72rem; color:var(--stone-300); font-weight:600;">+ Tambah <?= empty($items) ? 'menu' : 'lauk' ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<!-- Quick Links -->
<div style="display:flex; gap:8px; justify-content:center; margin-top:16px; flex-wrap:wrap;">
    <a href="<?= site_url('belanja') ?>" class="btn-mp btn-outline btn-sm">🛒 Belanja</a>
    <a href="<?= site_url('resep') ?>" class="btn-mp btn-outline btn-sm">📖 Resep</a>
    <a href="<?= site_url('master-harga') ?>" class="btn-mp btn-outline btn-sm">🏷️ Harga</a>
    <a href="<?= site_url('dashboard') ?>" class="btn-mp btn-outline btn-sm">🏠 Dashboard</a>
</div>


<!-- MODAL: Pilih Menu -->
<div class="mo" id="pickModal">
    <div class="mo-box">
        <div class="mo-head">
            <div>
                <h4>🍽️ Pilih Menu</h4>
                <p class="mo-sub" id="pickCtx">Senin, Pagi</p>
            </div>
            <button class="mo-x" onclick="closePick()">&times;</button>
        </div>
        <div class="mo-body">
            <div class="mo-search">
                <span class="mo-si">🔍</span>
                <input type="text" id="sInput" placeholder="Cari resep...">
            </div>
            <div class="mo-pills">
                <span class="mo-pill on" data-k="all">Semua</span>
                <?php foreach ($kategori as $k) : ?>
                    <span class="mo-pill" data-k="<?= $k->id_kategori ?>"><?= $k->icon ?></span>
                <?php endforeach; ?>
            </div>
            <div id="rpList" style="max-height:300px; overflow-y:auto;">
                <?php foreach ($resep_list as $r) : ?>
                    <div class="rp" data-id="<?= $r->id_resep ?>" data-k="<?= $r->id_kategori ?>" data-n="<?= htmlspecialchars(strtolower($r->nama_resep)) ?>" data-icon="<?= $r->icon ?? '🍽️' ?>" data-label="<?= htmlspecialchars($r->nama_resep) ?>" data-harga="<?= $r->estimasi_harga ?>" data-waktu="<?= $r->waktu_masak ?>" data-porsi="<?= $r->porsi ?>" data-kat="<?= $r->nama_kategori ?? '' ?>" onclick="pilih(this)">
                        <div class="rp-ic"><?= $r->icon ?? '🍽️' ?></div>
                        <div style="flex:1;min-width:0">
                            <div class="rp-nm"><?= htmlspecialchars($r->nama_resep) ?></div>
                            <div class="rp-sub">
                                <span>💰 Rp<?= number_format($r->estimasi_harga, 0, ',', '.') ?></span>
                                <span>⏱ <?= $r->waktu_masak ?>m</span>
                                <span>👥 <?= $r->porsi ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="mo-foot">
            <p style="font-size:.7rem; font-weight:600; color:var(--stone-400); margin-bottom:6px;">Atau ketik manual:</p>
            <div style="display:flex; gap:6px;">
                <input type="text" id="customInput" class="form-input" placeholder="Nama menu..." style="font-size:.85rem; flex:1;">
                <button class="btn-mp btn-brand btn-sm" onclick="simpanCustom()">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>


<script>
    var pTgl = '',
        pWaktu = '',
        pHari = '';
    var waktuLabels = {
        pagi: 'Pagi',
        siang: 'Siang',
        malam: 'Malam'
    };
    var waktuIcons = {
        pagi: '☀️',
        siang: '🌤️',
        malam: '🌙'
    };

    function openPick(tgl, waktu, hari) {
        pTgl = tgl;
        pWaktu = waktu;
        pHari = hari;
        document.getElementById('pickCtx').textContent = hari + ' ' + tgl.substring(8) + ' · ' + (waktuLabels[waktu] || waktu);
        document.getElementById('sInput').value = '';
        document.getElementById('customInput').value = '';
        filterList();
        document.getElementById('pickModal').classList.add('open');
        setTimeout(function() {
            document.getElementById('sInput').focus();
        }, 150);
    }

    function closePick() {
        document.getElementById('pickModal').classList.remove('open');
    }

    function toast(msg) {
        var t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(function() {
            t.classList.remove('show');
        }, 2200);
    }

    function parseRes(raw) {
        if (typeof raw === 'object') return raw;
        try {
            return JSON.parse(raw);
        } catch (e) {
            var i = raw.indexOf('{');
            if (i > -1) try {
                return JSON.parse(raw.substring(i));
            } catch (e2) {}
            return null;
        }
    }

    // Pilih resep — save & reload
    function pilih(el) {
        var tgl = pTgl,
            waktu = pWaktu;
        var id = el.dataset.id,
            label = el.dataset.label;
        closePick();
        toast('⏳ Menyimpan ' + label + '...');

        $.ajax({
            url: '<?= site_url("jadwal/simpan") ?>',
            method: 'POST',
            data: {
                tanggal: tgl,
                waktu_makan: waktu,
                id_resep: id
            },
            success: function(raw) {
                console.log('[DapurKita] Save response:', raw);
                var r = parseRes(raw);
                if (r && (r.status === 0 || r.id_jadwal > 0)) {
                    toast('✅ ' + label + ' ditambahkan!');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else {
                    toast('⚠️ Gagal: ' + (r ? (r.message || JSON.stringify(r.db_error)) : 'Response error'));
                    console.error('[DapurKita] Save failed:', r);
                }
            },
            error: function(xhr) {
                console.error('[DapurKita] AJAX Error:', xhr.responseText);
                toast('⚠️ Gagal simpan, cek console (F12)');
            }
        });
    }

    // Simpan custom
    function simpanCustom() {
        var nama = document.getElementById('customInput').value.trim();
        if (!nama) {
            document.getElementById('customInput').focus();
            return;
        }
        var tgl = pTgl,
            waktu = pWaktu;
        closePick();
        toast('⏳ Menyimpan ' + nama + '...');

        $.ajax({
            url: '<?= site_url("jadwal/simpan") ?>',
            method: 'POST',
            data: {
                tanggal: tgl,
                waktu_makan: waktu,
                nama_custom: nama
            },
            success: function(raw) {
                console.log('[DapurKita] Save response:', raw);
                var r = parseRes(raw);
                if (r && (r.status === 0 || r.id_jadwal > 0)) {
                    toast('✅ ' + nama + ' ditambahkan!');
                    document.getElementById('customInput').value = '';
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else {
                    toast('⚠️ Gagal: ' + (r ? (r.message || JSON.stringify(r.db_error)) : 'Response error'));
                }
            },
            error: function(xhr) {
                console.error('[DapurKita] AJAX Error:', xhr.responseText);
                toast('⚠️ Gagal simpan, cek console (F12)');
            }
        });
    }

    // Hapus — by id_jadwal, then reload
    function hapus(id) {
        if (!confirm('Hapus menu ini?')) return;
        var row = document.getElementById('mr-' + id);
        if (row) {
            row.style.transition = 'all .3s';
            row.style.opacity = '0';
            row.style.maxHeight = '0';
        }

        $.ajax({
            url: '<?= site_url("jadwal/hapus") ?>',
            method: 'POST',
            data: {
                id_jadwal: id
            },
            success: function() {
                toast('🗑️ Dihapus');
                setTimeout(function() {
                    location.reload();
                }, 500);
            },
            error: function() {
                toast('⚠️ Gagal hapus');
            }
        });
    }

    // Search & filter
    document.getElementById('sInput').addEventListener('input', filterList);

    function filterList() {
        var q = (document.getElementById('sInput').value || '').toLowerCase().trim();
        var pill = document.querySelector('.mo-pill.on');
        var k = pill ? pill.dataset.k : 'all';
        document.querySelectorAll('#rpList .rp').forEach(function(el) {
            var ok = (!q || el.dataset.n.indexOf(q) > -1) && (k === 'all' || el.dataset.k == k);
            el.style.display = ok ? '' : 'none';
        });
    }
    document.querySelectorAll('.mo-pill').forEach(function(p) {
        p.addEventListener('click', function() {
            document.querySelectorAll('.mo-pill').forEach(function(x) {
                x.classList.remove('on');
            });
            this.classList.add('on');
            filterList();
        });
    });

    // Modal close
    document.getElementById('pickModal').addEventListener('click', function(e) {
        if (e.target === this) closePick();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePick();
        if (e.key === 'Enter' && document.getElementById('pickModal').classList.contains('open')) {
            var v = document.getElementById('customInput').value.trim();
            if (v) simpanCustom();
        }
    });

    // Copy Minggu Lalu
    function copyMingguLalu() {
        if (!confirm('Copy semua menu dari minggu sebelumnya ke minggu ini?\nMenu yang sudah ada di slot yang sama akan ditimpa.')) return;
        var btn = document.getElementById('btnCopy');
        btn.disabled = true;
        btn.textContent = '⏳ Menyalin...';

        $.ajax({
            url: '<?= site_url("rencana/copy") ?>',
            method: 'POST',
            data: {
                week: <?= $week_offset ?>
            },
            success: function(raw) {
                var r = parseRes(raw);
                if (r && r.status === 0) {
                    toast('📋 ' + r.message);
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                } else {
                    toast('⚠️ Gagal copy: ' + (r ? r.message : 'unknown error'));
                    btn.disabled = false;
                    btn.textContent = '📋 Copy Minggu Lalu';
                }
            },
            error: function() {
                toast('⚠️ Gagal copy, coba lagi');
                btn.disabled = false;
                btn.textContent = '📋 Copy Minggu Lalu';
            }
        });
    }

    // Rekomendasi Otomatis
    function rekomendasi() {
        if (!confirm('Generate menu otomatis untuk minggu ini?\nMenu yang sudah ada akan ditimpa.')) return;
        var btn = document.getElementById('btnRekom');
        btn.disabled = true;
        btn.textContent = '⏳ Generating...';

        $.ajax({
            url: '<?= site_url("jadwal/rekomendasi") ?>',
            success: function(raw) {
                var r = parseRes(raw);
                if (r && r.status === 0 && r.rekomendasi && r.rekomendasi.length) {
                    // Adjust tanggal ke minggu yang sedang dilihat
                    var baseMonday = '<?= $senin ?>';
                    var adjusted = r.rekomendasi.map(function(item, i) {
                        // Hitung day offset dari senin (0-6)
                        var dayIdx = Math.floor(i / <?= count($waktu_keys) ?>);
                        var d = new Date(baseMonday);
                        d.setDate(d.getDate() + dayIdx);
                        item.tanggal = d.toISOString().split('T')[0];
                        return item;
                    });

                    $.ajax({
                        url: '<?= site_url("jadwal/apply") ?>',
                        method: 'POST',
                        data: {
                            items: JSON.stringify(adjusted)
                        },
                        success: function() {
                            toast('🤖 Menu digenerate!');
                            setTimeout(function() {
                                location.reload();
                            }, 600);
                        }
                    });
                } else {
                    toast('⚠️ Tidak ada resep yang cocok dengan budget');
                    btn.disabled = false;
                    btn.textContent = '🤖 Rekomendasi Otomatis';
                }
            },
            error: function() {
                toast('⚠️ Gagal generate');
                btn.disabled = false;
                btn.textContent = '🤖 Rekomendasi Otomatis';
            }
        });
    }
</script>
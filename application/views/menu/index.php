<!-- JADWAL MENU - Rewrite -->
<style>
    .cal-wrap {
        background: #fff;
        border: 1px solid var(--stone-200);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .cal-grid {
        display: grid;
        grid-template-columns: 68px repeat(<?= ($settings->frekuensi_makan ?? 3) ?>, 1fr);
    }

    .cal-hc {
        background: var(--stone-50);
        border-bottom: 2px solid var(--stone-200);
        border-right: 1px solid var(--stone-100);
        padding: 10px;
    }

    .cal-h {
        background: var(--stone-50);
        border-bottom: 2px solid var(--stone-200);
        border-right: 1px solid var(--stone-100);
        padding: 10px;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--stone-400);
        text-align: center;
    }

    .cal-h:last-child,
    .cal-hc:last-child {
        border-right: none;
    }

    .cal-day {
        background: var(--stone-50);
        border-right: 1px solid var(--stone-100);
        border-bottom: 1px solid var(--stone-100);
        padding: 8px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1px;
    }

    .cal-day .dn {
        font-size: .58rem;
        font-weight: 600;
        color: var(--stone-400);
    }

    .cal-day .dd {
        font-size: 1rem;
        font-weight: 800;
        color: var(--stone-700);
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .cal-day.is-today .dd {
        background: var(--brand);
        color: #fff;
    }

    .cal-day.is-past {
        opacity: .45;
    }

    .cal-cell {
        border-right: 1px solid var(--stone-100);
        border-bottom: 1px solid var(--stone-100);
        padding: 6px;
        min-height: 60px;
        transition: background .15s;
    }

    .cal-cell:last-child {
        border-right: none;
    }

    .cal-cell:hover {
        background: rgba(232, 93, 38, .02);
    }

    /* Menu chip */
    .mc {
        font-size: .72rem;
        font-weight: 600;
        padding: 5px 8px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all .2s;
        cursor: default;
        position: relative;
    }

    .mc-filled {
        background: linear-gradient(135deg, #fff3ee, #fef2f2);
        border: 1px solid rgba(232, 93, 38, .15);
        color: var(--brand-dark);
    }

    .mc-filled:hover {
        border-color: var(--brand);
        box-shadow: 0 2px 8px rgba(232, 93, 38, .1);
    }

    .mc-text {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .mc-price {
        font-size: .58rem;
        color: var(--stone-400);
        font-weight: 700;
    }

    .mc-x {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--stone-300);
        cursor: pointer;
        font-size: .6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all .15s;
        flex-shrink: 0;
    }

    .mc-filled:hover .mc-x {
        opacity: 1;
    }

    .mc-x:hover {
        background: var(--red);
        color: #fff;
    }

    /* Add button */
    .mc-add {
        font-size: .68rem;
        color: var(--stone-300);
        cursor: pointer;
        padding: 5px;
        border-radius: 7px;
        text-align: center;
        border: 1.5px dashed var(--stone-200);
        transition: all .2s;
    }

    .mc-add:hover {
        border-color: var(--brand);
        color: var(--brand);
        background: var(--brand-light);
    }

    /* Summary strip */
    .week-strip {
        display: flex;
        gap: 12px;
        padding: 12px 16px;
        background: var(--stone-50);
        border-top: 1px solid var(--stone-100);
        flex-wrap: wrap;
    }

    .ws-i {
        font-size: .72rem;
        font-weight: 600;
        color: var(--stone-500);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .ws-i strong {
        color: var(--stone-800);
    }

    .ws-i .ws-brand {
        color: var(--brand);
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 500;
        display: none;
        backdrop-filter: blur(4px);
    }

    .modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .m-box {
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

    .m-head {
        padding: 14px 18px;
        border-bottom: 1px solid var(--stone-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .m-head h4 {
        font-size: .92rem;
        font-weight: 700;
    }

    .m-head .m-sub {
        font-size: .72rem;
        color: var(--stone-400);
        font-weight: 600;
        margin-top: 2px;
    }

    .m-close {
        background: var(--stone-50);
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        color: var(--stone-400);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s;
    }

    .m-close:hover {
        background: var(--stone-200);
        color: var(--stone-800);
    }

    .m-body {
        padding: 14px 18px;
        overflow-y: auto;
        flex: 1;
    }

    /* Search in modal */
    .m-search {
        position: relative;
        margin-bottom: 10px;
    }

    .m-search input {
        width: 100%;
        font-family: var(--font);
        font-size: .85rem;
        padding: 9px 12px 9px 34px;
        border: 1.5px solid var(--stone-200);
        border-radius: 8px;
        background: var(--stone-50);
    }

    .m-search input:focus {
        outline: none;
        border-color: var(--brand);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(232, 93, 38, .08);
    }

    .m-search .m-si {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: .85rem;
    }

    /* Kategori pills in modal */
    .m-pills {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .m-pill {
        font-size: .68rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 14px;
        border: 1.5px solid var(--stone-200);
        background: #fff;
        color: var(--stone-500);
        cursor: pointer;
        transition: all .2s;
        white-space: nowrap;
    }

    .m-pill:hover {
        border-color: var(--brand);
        color: var(--brand);
    }

    .m-pill.active {
        background: var(--brand);
        color: #fff;
        border-color: var(--brand);
    }

    /* Resep pick items */
    .rp {
        padding: 8px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: all .15s;
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

    .rp-icon {
        font-size: 1.2rem;
        width: 32px;
        height: 32px;
        background: var(--stone-50);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .rp-name {
        font-size: .82rem;
        font-weight: 700;
        color: var(--stone-800);
    }

    .rp-sub {
        font-size: .65rem;
        color: var(--stone-400);
        font-weight: 600;
        display: flex;
        gap: 6px;
        margin-top: 1px;
    }

    .rp-sub span {
        display: flex;
        align-items: center;
        gap: 2px;
    }

    /* Custom input area */
    .m-custom {
        padding: 12px 18px;
        border-top: 1px solid var(--stone-100);
        background: var(--stone-50);
    }

    .m-custom-row {
        display: flex;
        gap: 6px;
    }

    .m-custom input {
        flex: 1;
        font-family: var(--font);
        font-size: .85rem;
        padding: 8px 12px;
        border: 1.5px solid var(--stone-200);
        border-radius: 8px;
        background: #fff;
    }

    .m-custom input:focus {
        outline: none;
        border-color: var(--brand);
    }

    /* Saving indicator */
    .saving-toast {
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
        box-shadow: 0 8px 24px rgba(232, 93, 38, .25);
    }

    .saving-toast.show {
        display: block;
        animation: fadeUp .3s var(--ease);
    }

    @media(max-width:640px) {
        .cal-grid {
            grid-template-columns: 55px repeat(<?= ($settings->frekuensi_makan ?? 3) ?>, 1fr);
        }

        .cal-day .dn {
            font-size: .5rem;
        }

        .cal-day .dd {
            font-size: .85rem;
            width: 24px;
            height: 24px;
        }

        .mc {
            font-size: .65rem;
            padding: 4px 6px;
        }

        .mc-add {
            font-size: .6rem;
            padding: 4px;
        }
    }
</style>

<?php
$waktu_list = ['pagi' => '☀️ Pagi', 'siang' => '🌤️ Siang', 'malam' => '🌙 Malam'];
if (($settings->frekuensi_makan ?? 3) == 2) unset($waktu_list['siang']);
$hari_indo = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

// Hitung estimasi total
$est_total = 0;
$filled = 0;
$total_slots = 7 * count($waktu_list);
foreach ($grid as $tgl => $slots) {
    foreach ($waktu_list as $wk => $wl) {
        $item = $slots[$wk] ?? null;
        if ($item) {
            $filled++;
            $est_total += (float)($item->estimasi_harga ?? 0);
        }
    }
}
?>

<!-- Header -->
<div class="d-flex justify-between items-center" style="margin-bottom:14px;">
    <div>
        <h1 style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; letter-spacing:-.03em; color:var(--stone-900);">📅 Jadwal Menu</h1>
        <p class="fs-sm text-muted"><?= date('d M', strtotime($senin)) ?> — <?= date('d M Y', strtotime($minggu)) ?></p>
    </div>
    <div style="display:flex; align-items:center; gap:4px;">
        <a href="<?= site_url('jadwal?week_offset=' . ($week_offset - 1)) ?>" class="btn-mp btn-outline btn-sm" style="padding:6px 10px;">←</a>
        <a href="<?= site_url('jadwal?week_offset=0') ?>" class="btn-mp btn-outline btn-sm">Minggu ini</a>
        <a href="<?= site_url('jadwal?week_offset=' . ($week_offset + 1)) ?>" class="btn-mp btn-outline btn-sm" style="padding:6px 10px;">→</a>
    </div>
</div>

<!-- Toolbar -->
<div style="display:flex; gap:6px; margin-bottom:14px; flex-wrap:wrap;">
    <a href="<?= site_url('jadwal/copy') ?>" class="btn-mp btn-outline btn-sm" onclick="return confirm('Copy semua menu dari minggu lalu?')">📋 Copy Minggu Lalu</a>
    <button class="btn-mp btn-brand btn-sm" id="btnRekom">🤖 Rekomendasi Otomatis</button>
    <a href="<?= site_url('resep') ?>" class="btn-mp btn-outline btn-sm">📖 Database Resep</a>
</div>

<!-- Calendar -->
<div class="cal-wrap anim-up">
    <!-- Header -->
    <div class="cal-grid">
        <div class="cal-hc"></div>
        <?php foreach ($waktu_list as $key => $label) : ?>
            <div class="cal-h"><?= $label ?></div>
        <?php endforeach; ?>

        <!-- Rows -->
        <?php $d = 0;
        foreach ($grid as $tgl => $slots) :
            $is_today = ($tgl == date('Y-m-d'));
            $is_past = ($tgl < date('Y-m-d'));
        ?>
            <div class="cal-day <?= $is_today ? 'is-today' : '' ?> <?= $is_past ? 'is-past' : '' ?>">
                <span class="dn"><?= $hari_indo[$d] ?></span>
                <span class="dd"><?= date('d', strtotime($tgl)) ?></span>
            </div>

            <?php foreach ($waktu_list as $wkey => $wlabel) :
                $item = $slots[$wkey] ?? null;
            ?>
                <div class="cal-cell" id="cell-<?= $tgl ?>-<?= $wkey ?>">
                    <?php if ($item) : ?>
                        <div class="mc mc-filled" id="mc-<?= $tgl ?>-<?= $wkey ?>">
                            <span><?= $item->icon ?? '🍽️' ?></span>
                            <span class="mc-text" title="<?= htmlspecialchars($item->nama_resep ?: $item->nama_custom) ?>">
                                <?= htmlspecialchars($item->nama_resep ?: $item->nama_custom) ?>
                            </span>
                            <?php if ($item->estimasi_harga) : ?>
                                <span class="mc-price"><?= number_format($item->estimasi_harga, 0, ',', '.') ?></span>
                            <?php endif; ?>
                            <button class="mc-x" onclick="hapusMenu(<?= $item->id_jadwal ?>, '<?= $tgl ?>', '<?= $wkey ?>')" title="Hapus">&times;</button>
                        </div>
                    <?php else : ?>
                        <div class="mc-add" id="add-<?= $tgl ?>-<?= $wkey ?>" onclick="openPick('<?= $tgl ?>','<?= $wkey ?>','<?= $hari_indo[$d] ?>')">+ Menu</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php $d++;
        endforeach; ?>
    </div>

    <!-- Summary strip -->
    <div class="week-strip">
        <div class="ws-i">📊 Terisi: <strong><?= $filled ?>/<?= $total_slots ?></strong></div>
        <div class="ws-i">💰 Estimasi: <strong class="ws-brand">Rp<?= number_format($est_total, 0, ',', '.') ?></strong></div>
        <?php
        $budget_obj = isset($budget) ? $budget : null;
        $budget_amt = $budget_obj ? (float)$budget_obj->budget_amount : (float)($settings->budget_mingguan ?? 300000);
        $sisa_est = $budget_amt - $est_total;
        ?>
        <div class="ws-i">🏦 Budget: <strong>Rp<?= number_format($budget_amt, 0, ',', '.') ?></strong></div>
        <div class="ws-i">
            <?= $sisa_est >= 0 ? '✅' : '⚠️' ?> Sisa:
            <strong style="color:<?= $sisa_est >= 0 ? 'var(--green)' : 'var(--red)' ?>">
                Rp<?= number_format(abs($sisa_est), 0, ',', '.') ?><?= $sisa_est < 0 ? ' over!' : '' ?>
            </strong>
        </div>
    </div>
</div>


<!-- MODAL: Pilih Menu -->
<div class="modal-overlay" id="pickModal">
    <div class="m-box">
        <div class="m-head">
            <div>
                <h4>🍽️ Pilih Menu</h4>
                <p class="m-sub" id="pickContext">Senin, Pagi</p>
            </div>
            <button class="m-close" onclick="closePick()">&times;</button>
        </div>
        <div class="m-body">
            <!-- Search -->
            <div class="m-search">
                <span class="m-si">🔍</span>
                <input type="text" id="sResep" placeholder="Cari resep...">
            </div>

            <!-- Kategori -->
            <div class="m-pills">
                <span class="m-pill active" data-kat="all">Semua</span>
                <?php foreach ($kategori as $k) : ?>
                    <span class="m-pill" data-kat="<?= $k->id_kategori ?>"><?= $k->icon ?></span>
                <?php endforeach; ?>
            </div>

            <!-- Resep list -->
            <div id="rpList" style="max-height:320px; overflow-y:auto;">
                <?php foreach ($resep_list as $r) : ?>
                    <div class="rp" data-id="<?= $r->id_resep ?>" data-kat="<?= $r->id_kategori ?>" data-nama="<?= htmlspecialchars(strtolower($r->nama_resep)) ?>" data-icon="<?= $r->icon ?? '🍽️' ?>" data-label="<?= htmlspecialchars($r->nama_resep) ?>" data-harga="<?= $r->estimasi_harga ?>" onclick="pilihResep(this)">
                        <div class="rp-icon"><?= $r->icon ?? '🍽️' ?></div>
                        <div style="flex:1; min-width:0;">
                            <div class="rp-name"><?= htmlspecialchars($r->nama_resep) ?></div>
                            <div class="rp-sub">
                                <span>💰 Rp<?= number_format($r->estimasi_harga, 0, ',', '.') ?></span>
                                <span>⏱ <?= $r->waktu_masak ?>m</span>
                                <span>👥 <?= $r->porsi ?></span>
                                <?php if ($r->is_meal_prep) : ?><span>📦</span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($resep_list)) : ?>
                    <div class="text-center" style="padding:2rem">
                        <p class="text-muted fs-sm">Belum ada resep. <a href="<?= site_url('resep') ?>">Tambah resep →</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Custom input -->
        <div class="m-custom">
            <p class="fs-xs text-muted mb-1" style="font-weight:600;">Atau ketik manual:</p>
            <div class="m-custom-row">
                <input type="text" id="customMenu" placeholder="Nama menu...">
                <button class="btn-mp btn-brand btn-sm" onclick="simpanCustom()">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Saving Toast -->
<div class="saving-toast" id="savingToast">✅ Menu disimpan!</div>


<script>
    var selTgl = '',
        selWaktu = '',
        selLabel = '';

    function openPick(tgl, waktu, hari) {
        selTgl = tgl;
        selWaktu = waktu;
        var waktuLabel = {
            pagi: 'Pagi',
            siang: 'Siang',
            malam: 'Malam'
        };
        document.getElementById('pickContext').textContent = hari + ' ' + tgl.substring(8) + ', ' + (waktuLabel[waktu] || waktu);
        document.getElementById('sResep').value = '';
        filterResep();
        document.getElementById('pickModal').classList.add('active');
        setTimeout(function() {
            document.getElementById('sResep').focus();
        }, 200);
    }

    function closePick() {
        document.getElementById('pickModal').classList.remove('active');
    }

    function showToast(msg) {
        var t = document.getElementById('savingToast');
        t.textContent = msg || '✅ Menu disimpan!';
        t.classList.add('show');
        setTimeout(function() {
            t.classList.remove('show');
        }, 2000);
    }

    // Pilih dari list
    function pilihResep(el) {
        var id = el.dataset.id;
        var icon = el.dataset.icon;
        var label = el.dataset.label;
        var harga = el.dataset.harga;
        var tgl = selTgl,
            waktu = selWaktu;

        closePick();
        updateCell(tgl, waktu, icon, label, harga, null);

        console.log('[MealPlan] Saving:', {
            tanggal: tgl,
            waktu_makan: waktu,
            id_resep: id
        });

        $.ajax({
            url: '<?= site_url("jadwal/simpan") ?>',
            method: 'POST',
            data: {
                tanggal: tgl,
                waktu_makan: waktu,
                id_resep: id
            },
            success: function(raw) {
                console.log('[MealPlan] Raw response:', raw);
                var res = parseJSON(raw);
                console.log('[MealPlan] Parsed:', res);

                if (res && res.status === 0 && res.id_jadwal) {
                    updateCell(tgl, waktu, icon, label, harga, res.id_jadwal);
                    showToast('✅ ' + label + ' tersimpan!');
                } else if (res && res.status === 1) {
                    showToast('⚠️ ' + (res.message || 'Gagal simpan'));
                    revertCell(tgl, waktu);
                } else {
                    // Response tidak jelas, keep cell tapi warn
                    showToast('⚠️ Response tidak valid, refresh halaman');
                    console.warn('[MealPlan] Invalid response:', raw);
                }
            },
            error: function(xhr, status, err) {
                console.error('[MealPlan] AJAX Error:', status, err, xhr.responseText);
                showToast('⚠️ Gagal menyimpan: ' + (err || status));
                revertCell(tgl, waktu);
            }
        });
    }

    // Simpan custom
    function simpanCustom() {
        var nama = document.getElementById('customMenu').value.trim();
        if (!nama) {
            document.getElementById('customMenu').focus();
            return;
        }

        var tgl = selTgl,
            waktu = selWaktu;
        closePick();
        updateCell(tgl, waktu, '🍽️', nama, 0, null);

        console.log('[MealPlan] Saving custom:', {
            tanggal: tgl,
            waktu_makan: waktu,
            nama_custom: nama
        });

        $.ajax({
            url: '<?= site_url("jadwal/simpan") ?>',
            method: 'POST',
            data: {
                tanggal: tgl,
                waktu_makan: waktu,
                nama_custom: nama
            },
            success: function(raw) {
                console.log('[MealPlan] Raw response:', raw);
                var res = parseJSON(raw);

                if (res && res.status === 0 && res.id_jadwal) {
                    updateCell(tgl, waktu, '🍽️', nama, 0, res.id_jadwal);
                    showToast('✅ ' + nama + ' tersimpan!');
                } else {
                    showToast('⚠️ Response tidak valid, refresh halaman');
                }
                document.getElementById('customMenu').value = '';
            },
            error: function(xhr, status, err) {
                console.error('[MealPlan] AJAX Error:', status, err, xhr.responseText);
                showToast('⚠️ Gagal menyimpan');
                revertCell(tgl, waktu);
            }
        });
    }

    // Parse JSON safely (handles PHP notices before JSON)
    function parseJSON(raw) {
        if (typeof raw === 'object') return raw;
        try {
            // Coba parse langsung
            return JSON.parse(raw);
        } catch (e) {
            // Mungkin ada PHP notice sebelum JSON, cari { terakhir
            var idx = raw.lastIndexOf('{');
            if (idx > -1) {
                try {
                    return JSON.parse(raw.substring(idx));
                } catch (e2) {}
            }
            // Cari dari depan
            idx = raw.indexOf('{');
            if (idx > -1) {
                try {
                    return JSON.parse(raw.substring(idx));
                } catch (e3) {}
            }
            return null;
        }
    }

    // Update cell with menu chip + delete button
    function updateCell(tgl, waktu, icon, label, harga, jadwalId) {
        var cell = document.getElementById('cell-' + tgl + '-' + waktu);
        if (!cell) return;
        var priceHtml = harga > 0 ? '<span class="mc-price">' + Number(harga).toLocaleString('id-ID') + '</span>' : '';
        var delBtn = '';
        if (jadwalId) {
            delBtn = '<button class="mc-x" onclick="hapusMenu(' + jadwalId + ',\'' + tgl + '\',\'' + waktu + '\')" title="Hapus">&times;</button>';
        }
        cell.innerHTML = '<div class="mc mc-filled" style="animation:fadeUp .3s var(--ease)">' +
            '<span>' + icon + '</span>' +
            '<span class="mc-text" title="' + escHtml(label) + '">' + escHtml(label) + '</span>' +
            priceHtml + delBtn +
            '</div>';
    }

    function revertCell(tgl, waktu) {
        var cell = document.getElementById('cell-' + tgl + '-' + waktu);
        if (!cell) return;
        cell.innerHTML = '<div class="mc-add" onclick="openPick(\'' + tgl + '\',\'' + waktu + '\',\'\')">+ Menu</div>';
    }

    // Hapus
    function hapusMenu(id, tgl, waktu) {
        if (!confirm('Hapus menu ini?')) return;
        revertCell(tgl, waktu);

        $.ajax({
            url: '<?= site_url("jadwal/hapus") ?>',
            method: 'POST',
            data: {
                id_jadwal: id
            },
            success: function() {
                showToast('🗑️ Menu dihapus');
            },
            error: function() {
                showToast('⚠️ Gagal menghapus, refresh halaman');
            }
        });
    }

    // Search resep
    document.getElementById('sResep').addEventListener('input', filterResep);

    function filterResep() {
        var q = (document.getElementById('sResep').value || '').toLowerCase().trim();
        var activePill = document.querySelector('.m-pill.active');
        var kat = activePill ? activePill.dataset.kat : 'all';

        document.querySelectorAll('#rpList .rp').forEach(function(el) {
            var matchName = !q || el.dataset.nama.indexOf(q) > -1;
            var matchKat = (kat === 'all') || (el.dataset.kat == kat);
            el.style.display = (matchName && matchKat) ? '' : 'none';
        });
    }

    // Kategori pills
    document.querySelectorAll('.m-pill').forEach(function(pill) {
        pill.addEventListener('click', function() {
            document.querySelectorAll('.m-pill').forEach(function(p) {
                p.classList.remove('active');
            });
            this.classList.add('active');
            filterResep();
        });
    });

    // Rekomendasi — ini satu-satunya yang perlu reload karena banyak data
    document.getElementById('btnRekom').addEventListener('click', function() {
        if (!confirm('Generate menu otomatis untuk minggu ini?\nMenu yang sudah ada akan ditimpa.')) return;
        var btn = this;
        btn.disabled = true;
        btn.textContent = '⏳ Generating...';

        $.ajax({
            url: '<?= site_url("jadwal/rekomendasi") ?>',
            success: function(raw) {
                var r = parseJSON(raw);
                if (r && r.status === 0 && r.rekomendasi && r.rekomendasi.length) {
                    $.ajax({
                        url: '<?= site_url("jadwal/apply") ?>',
                        method: 'POST',
                        data: {
                            items: JSON.stringify(r.rekomendasi)
                        },
                        success: function() {
                            showToast('🤖 Menu digenerate! Memuat ulang...');
                            setTimeout(function() {
                                location.reload();
                            }, 600);
                        }
                    });
                } else {
                    showToast('⚠️ Tidak ada resep yang cocok');
                    btn.disabled = false;
                    btn.textContent = '🤖 Rekomendasi Otomatis';
                }
            },
            error: function() {
                showToast('⚠️ Gagal generate');
                btn.disabled = false;
                btn.textContent = '🤖 Rekomendasi Otomatis';
            }
        });
    });

    // Close on overlay
    document.getElementById('pickModal').addEventListener('click', function(e) {
        if (e.target === this) closePick();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePick();
        if (e.key === 'Enter' && document.getElementById('pickModal').classList.contains('active')) {
            var val = document.getElementById('customMenu').value.trim();
            if (val) simpanCustom();
        }
    });
</script>
<!-- DAPUR - Budget + Pengeluaran Dapur + Menu Hari Ini (ALL IN ONE) -->
<style>
    .week-nav{display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:14px}
    .week-nav a,.week-nav span{font-size:.78rem;font-weight:700;padding:6px 14px;border-radius:8px;text-decoration:none;transition:all .2s}
    .week-nav a{color:var(--stone-500);border:1px solid var(--rose-200);background:#fff}
    .week-nav a:hover{border-color:var(--brand);color:var(--brand);background:var(--brand-light)}
    .week-nav .wn-cur{background:var(--brand);color:#fff;border:none;font-size:.65rem;padding:4px 10px;border-radius:6px}
    .bb-edit{background:none;border:none;cursor:pointer;font-size:.72rem;color:rgba(255,255,255,.7);text-decoration:underline;font-family:inherit;font-weight:600}.bb-edit:hover{color:#fff}

    .px-row{display:flex;align-items:center;gap:10px;padding:11px 16px;border-bottom:1px solid var(--rose-100);transition:all .2s}
    .px-row:hover{background:var(--brand-light)}.px-row:last-child{border-bottom:none}
    .px-icon{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0}
    .px-info{flex:1;min-width:0}
    .px-name{font-size:.85rem;font-weight:700;color:var(--stone-800)}
    .px-sub{font-size:.65rem;color:var(--stone-400);font-weight:600}
    .px-price{font-size:.85rem;font-weight:800;color:var(--brand);white-space:nowrap;min-width:90px;text-align:right}
    .px-act{display:flex;gap:2px;opacity:0;transition:opacity .15s}
    .px-row:hover .px-act{opacity:1}
    .px-btn{width:26px;height:26px;border-radius:6px;border:none;background:transparent;cursor:pointer;font-size:.65rem;display:flex;align-items:center;justify-content:center;transition:all .15s}
    .px-btn:hover{background:var(--rose-100)}
    .px-btn.del:hover{background:var(--red-soft);color:var(--red)}

    .mo{position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:500;display:none;backdrop-filter:blur(4px)}
    .mo.open{display:flex;align-items:center;justify-content:center;padding:16px}
    .mo-box{background:#fff;border-radius:var(--radius);box-shadow:0 24px 80px rgba(0,0,0,.15);width:100%;max-width:420px;overflow:hidden}
    .mo-head{padding:14px 18px;border-bottom:1px solid var(--rose-100);display:flex;justify-content:space-between;align-items:center}
    .mo-head h4{font-size:.92rem;font-weight:800}
    .mo-x{background:var(--stone-100);border:none;width:30px;height:30px;border-radius:8px;font-size:1.1rem;cursor:pointer;color:var(--stone-400)}.mo-x:hover{background:var(--stone-200)}
    .mo-body{padding:16px 18px}
</style>

<?php
$w = $week_offset;
$senin = $budget->tanggal_mulai;
$minggu_end = $budget->tanggal_selesai;
$kat_icons = ['lauk'=>['🍗','#fff0f2'],'sayur'=>['🥬','#edfcf2'],'bahan_pokok'=>['🍚','#fef8ec'],'bumbu'=>['🧂','#f5f0ff'],'snack'=>['🍿','#fef8ec'],'lainnya'=>['📦','#f8f6f4']];
?>

<div class="page-header">
    <p class="fs-sm text-muted"><?= date('d M', strtotime($senin)) ?> — <?= date('d M Y', strtotime($minggu_end)) ?></p>
    <h1>🍽️ Dapur</h1>
</div>

<!-- Week Nav -->
<div class="week-nav anim-up">
    <a href="<?= site_url('dapur?week='.($w-1)) ?>">← Minggu Lalu</a>
    <?php if ($w != 0): ?>
        <a href="<?= site_url('dapur') ?>" class="wn-cur">Minggu Ini</a>
    <?php else: ?>
        <span class="wn-cur">📍 Minggu Ini</span>
    <?php endif; ?>
    <a href="<?= site_url('dapur?week='.($w+1)) ?>">Minggu Depan →</a>
</div>

<!-- ═══ BUDGET CARD ═══ -->
<div class="mp-card anim-up mb-2" style="background:linear-gradient(135deg, #f078a0, var(--brand)); border:none; color:#fff;">
    <div class="mp-card-body" style="padding:1.5rem">
        <div class="d-flex justify-between items-center" style="margin-bottom:14px">
            <div>
                <p style="font-size:.68rem;font-weight:600;opacity:.7;text-transform:uppercase;letter-spacing:.06em">Budget Minggu Ini</p>
                <p style="font-size:2rem;font-weight:800;letter-spacing:-.03em" id="budgetDisp">Rp<?= number_format($budget->budget_amount, 0, ',', '.') ?></p>
                <?php if ($budget->id_budget): ?>
                    <button class="bb-edit" onclick="openModal('editBudget')">✏️ Edit Budget</button>
                <?php endif; ?>
            </div>
            <div style="width:60px;height:60px;border-radius:50%;border:4px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;position:relative">
                <svg width="60" height="60" viewBox="0 0 60 60" style="position:absolute;transform:rotate(-90deg)">
                    <circle cx="30" cy="30" r="26" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="4"/>
                    <circle cx="30" cy="30" r="26" fill="none" stroke="#fff" stroke-width="4" stroke-dasharray="<?= round(163.36 * min($persen_budget,100)/100) ?> 163.36" stroke-linecap="round"/>
                </svg>
                <span style="font-size:.82rem;font-weight:800;position:relative;z-index:1"><?= $persen_budget ?>%</span>
            </div>
        </div>
        <?php $sisa_total = $sisa_prev + $sisa; ?>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px">
            <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:8px 12px"><p style="font-size:.6rem;opacity:.7;font-weight:600">🛒 Belanja</p><p style="font-size:1rem;font-weight:800">Rp<?= number_format($terpakai, 0, ',', '.') ?></p></div>
            <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:8px 12px"><p style="font-size:.6rem;opacity:.7;font-weight:600">💰 Sisa</p><p style="font-size:1rem;font-weight:800;<?= $sisa < 0 ? 'color:#fca5a5' : '' ?>"><?= $sisa < 0 ? '-' : '' ?>Rp<?= number_format(abs($sisa), 0, ',', '.') ?></p></div>
            <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:8px 12px"><p style="font-size:.6rem;opacity:.7;font-weight:600">📊 Sisa + Lalu</p><p style="font-size:1rem;font-weight:800;<?= $sisa_total < 0 ? 'color:#fca5a5' : '' ?>"><?= $sisa_total < 0 ? '-' : '' ?>Rp<?= number_format(abs($sisa_total), 0, ',', '.') ?></p></div>
        </div>
    </div>
</div>

<!-- ═══ PENGELUARAN LIST (grouped by date) ═══ -->
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3>💸 Pengeluaran Dapur</h3>
        <button class="btn-mp btn-brand btn-sm" onclick="openModal('addPx')" style="font-size:.7rem;padding:5px 12px">+ Catat</button>
    </div>
    <?php if (empty($pengeluaran_list)): ?>
    <div class="mp-card-body text-center" style="padding:2rem">
        <p style="font-size:2rem;margin-bottom:6px">📝</p>
        <p style="font-weight:700;color:var(--stone-500);margin-bottom:4px">Belum ada pengeluaran</p>
        <p class="fs-xs text-muted mb-1">Catat belanja dapur minggu ini.</p>
        <button class="btn-mp btn-brand btn-sm" onclick="openModal('addPx')">+ Catat Pengeluaran</button>
    </div>
    <?php else: ?>
    <?php
    // Group by date
    $grouped = [];
    foreach ($pengeluaran_list as $px) {
        $tgl = $px->tanggal;
        if (!isset($grouped[$tgl])) $grouped[$tgl] = [];
        $grouped[$tgl][] = $px;
    }
    krsort($grouped); // newest date first
    $nama_hari = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
    ?>
    <div style="padding:0">
        <?php foreach ($grouped as $tgl => $items):
            $total_tgl = array_sum(array_map(fn($p) => (float)$p->harga, $items));
            $hari_en = date('l', strtotime($tgl));
            $hari = $nama_hari[$hari_en] ?? $hari_en;
            $is_today = ($tgl == date('Y-m-d'));
        ?>
        <!-- Date Header -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 16px;background:<?= $is_today ? 'var(--brand-light)' : 'var(--stone-50)' ?>;border-bottom:1px solid var(--rose-100)">
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:.75rem"><?= $is_today ? '📍' : '📅' ?></span>
                <span style="font-size:.8rem;font-weight:800;color:<?= $is_today ? 'var(--brand)' : 'var(--stone-700)' ?>"><?= $hari ?>, <?= date('d M Y', strtotime($tgl)) ?></span>
                <?php if ($is_today): ?><span style="font-size:.55rem;font-weight:700;background:var(--brand);color:#fff;padding:2px 6px;border-radius:4px">Hari Ini</span><?php endif; ?>
            </div>
            <span style="font-size:.72rem;font-weight:800;color:#fff;background:var(--brand);padding:4px 12px;border-radius:20px">Rp<?= number_format($total_tgl, 0, ',', '.') ?></span>
        </div>

        <!-- Items for this date -->
        <?php foreach ($items as $px):
            $ki = $kat_icons[$px->kategori ?? 'lainnya'] ?? $kat_icons['lainnya'];
        ?>
        <div class="px-row" id="px-<?= $px->id_pengeluaran ?>"
            data-nama="<?= htmlspecialchars($px->nama_barang) ?>"
            data-harga="<?= $px->harga ?>"
            data-kategori="<?= $px->kategori ?>"
            data-tanggal="<?= $px->tanggal ?>"
            data-catatan="<?= htmlspecialchars($px->catatan ?? '') ?>"
            style="padding-left:36px">
            <div class="px-icon" style="background:<?= $ki[1] ?>;width:30px;height:30px;font-size:.85rem"><?= $ki[0] ?></div>
            <div class="px-info">
                <p class="px-name"><?= htmlspecialchars($px->nama_barang) ?></p>
                <p class="px-sub"><?= ucfirst($px->kategori ?? 'lainnya') ?><?= $px->catatan ? ' · '.$px->catatan : '' ?> · <span style="color:var(--stone-600);font-weight:700">Rp<?= number_format($px->harga, 0, ',', '.') ?></span></p>
            </div>
            <div class="px-act">
                <button class="px-btn" onclick="editPx(<?= $px->id_pengeluaran ?>)" title="Edit">✏️</button>
                <button class="px-btn del" onclick="hapusPx(<?= $px->id_pengeluaran ?>)" title="Hapus">🗑</button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div style="padding:10px 16px;border-top:1px solid var(--rose-100);display:flex;justify-content:space-between;align-items:center">
        <span class="fs-sm" style="font-weight:700;color:var(--stone-500)">Total <?= count($pengeluaran_list) ?> transaksi</span>
        <span style="font-size:.95rem;font-weight:800;color:var(--brand)">Rp<?= number_format($terpakai, 0, ',', '.') ?></span>
    </div>
    <?php endif; ?>
</div>

<!-- ═══ PER KATEGORI ═══ -->
<?php if (!empty($by_kategori)): ?>
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header"><h3>📊 Per Kategori</h3></div>
    <div style="padding:0">
        <?php foreach ($by_kategori as $k):
            $ki = $kat_icons[$k->kategori ?? 'lainnya'] ?? $kat_icons['lainnya'];
            $pct = $terpakai > 0 ? round((float)$k->total / $terpakai * 100) : 0;
        ?>
        <div style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-bottom:1px solid var(--rose-100)">
            <div class="px-icon" style="background:<?= $ki[1] ?>"><?= $ki[0] ?></div>
            <div style="flex:1">
                <div class="d-flex justify-between items-center" style="margin-bottom:4px">
                    <span style="font-size:.82rem;font-weight:700"><?= ucfirst($k->kategori ?? 'Lainnya') ?></span>
                    <span style="font-size:.78rem;font-weight:800;color:var(--brand)">Rp<?= number_format($k->total, 0, ',', '.') ?></span>
                </div>
                <div style="height:5px;background:var(--rose-100);border-radius:3px;overflow:hidden">
                    <div style="height:100%;width:<?= $pct ?>%;background:var(--brand);border-radius:3px;transition:width .5s"></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ═══ QUICK CARDS ═══ -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px" class="mb-2 anim-up">
    <div class="mp-card"><div class="mp-card-body text-center" style="padding:1rem">
        <p style="font-size:1.5rem;margin-bottom:4px">📅</p>
        <p style="font-size:1.1rem;font-weight:800"><?= $slot_terisi ?>/<?= $total_slot ?></p>
        <p class="fs-xs text-muted">Menu Terisi</p>
    </div></div>
    <a href="<?= site_url('rencana') ?>" class="mp-card" style="text-decoration:none"><div class="mp-card-body text-center" style="padding:1rem">
        <p style="font-size:1.5rem;margin-bottom:4px">🤖</p>
        <p style="font-size:.85rem;font-weight:800;color:var(--brand)">Rekomendasi</p>
        <p class="fs-xs text-muted">Auto Generate Menu</p>
    </div></a>
</div>

<!-- ═══ MENU HARI INI ═══ -->
<?php if ($is_current): ?>
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header"><h3>🍳 Menu Hari Ini</h3><span class="badge badge-brand"><?= date('l, d M') ?></span></div>
    <?php $today_menu = array_values($jadwal_hari_ini); ?>
    <?php if (empty($today_menu)): ?>
    <div class="mp-card-body text-center" style="padding:1.5rem">
        <p style="font-size:2rem;margin-bottom:6px">📋</p>
        <p style="font-weight:600;color:var(--stone-400)">Belum ada menu hari ini</p>
        <a href="<?= site_url('rencana') ?>" class="btn-mp btn-brand btn-sm mt-1">Buat Jadwal</a>
    </div>
    <?php else: ?>
    <div style="padding:0">
        <?php $wi = ['pagi'=>'☀️','siang'=>'🌤️','malam'=>'🌙'];
        foreach ($today_menu as $j): ?>
        <div style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-bottom:1px solid var(--rose-100)">
            <span style="font-size:1.1rem"><?= $wi[$j->waktu_makan] ?? '🍽️' ?></span>
            <div style="flex:1"><p style="font-size:.85rem;font-weight:700"><?= htmlspecialchars($j->nama_resep ?: $j->nama_custom ?: '-') ?></p><p class="fs-xs text-muted"><?= ucfirst($j->waktu_makan) ?></p></div>
            <?php if ($j->estimasi_harga > 0): ?><span style="font-size:.8rem;font-weight:700;color:var(--brand)">Rp<?= number_format($j->estimasi_harga, 0, ',', '.') ?></span><?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- ═══ FITUR 4: CATATAN MINGGU ═══ -->
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3>📝 Catatan Minggu</h3>
        <button class="btn-mp btn-ghost btn-sm" id="catatanToggle" onclick="toggleCatatan()" style="font-size:.7rem">✏️ Edit</button>
    </div>
    <div class="mp-card-body" style="padding:12px 16px">
        <div id="catatanDisplay" style="font-size:.85rem;color:var(--stone-600);line-height:1.6;min-height:24px">
            <?= htmlspecialchars($catatan_minggu->catatan ?? '') ?: '<span style="color:var(--stone-400);font-style:italic">Belum ada catatan. Klik Edit untuk menambah catatan minggu ini.</span>' ?>
        </div>
        <div id="catatanEdit" style="display:none">
            <textarea id="catatanInput" class="form-input" rows="3" placeholder="cth: Minggu ini ada tamu, masak lebih banyak..." style="font-size:.85rem;resize:vertical"><?= htmlspecialchars($catatan_minggu->catatan ?? '') ?></textarea>
            <div class="d-flex gap-1 mt-1" style="justify-content:flex-end">
                <button class="btn-mp btn-outline btn-sm" onclick="toggleCatatan()">Batal</button>
                <button class="btn-mp btn-brand btn-sm" onclick="saveCatatan()">💾 Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- ═══ MODAL: Catat Pengeluaran ═══ -->
<div class="mo" id="addPx">
    <div class="mo-box">
        <div class="mo-head"><h4>💸 Catat Pengeluaran Dapur</h4><button class="mo-x" onclick="closeModal('addPx')">&times;</button></div>
        <div class="mo-body">
            <form action="<?= site_url('pengeluaran/simpan') ?>" method="POST">
                <input type="hidden" name="week_offset" value="<?= $w ?>">
                <div class="form-group"><label>Nama Barang *</label><input type="text" name="nama_barang" class="form-input" required placeholder="cth: Ayam, Beras, Minyak" list="bahanSuggest"><datalist id="bahanSuggest"></datalist></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group"><label>Harga (Rp) *</label><input type="number" name="harga" class="form-input" required min="500" step="500" placeholder="15000" id="addHarga"></div>
                    <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" class="form-input" value="<?= date('Y-m-d') ?>"></div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group"><label>Kategori</label>
                        <select name="kategori" class="form-input">
                            <option value="lauk">🍗 Lauk</option><option value="sayur">🥬 Sayur</option><option value="bahan_pokok">🍚 Bahan Pokok</option><option value="bumbu">🧂 Bumbu</option><option value="snack">🍿 Snack</option><option value="lainnya">📦 Lainnya</option>
                        </select></div>
                    <div class="form-group"><label>Catatan</label><input type="text" name="catatan" class="form-input" placeholder="(opsional)"></div>
                </div>
                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('addPx')">Batal</button>
                    <button type="submit" class="btn-mp btn-brand" style="flex:2;justify-content:center">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ═══ MODAL: Edit Pengeluaran ═══ -->
<div class="mo" id="editPx">
    <div class="mo-box">
        <div class="mo-head"><h4>✏️ Edit Pengeluaran</h4><button class="mo-x" onclick="closeModal('editPx')">&times;</button></div>
        <div class="mo-body">
            <form action="<?= site_url('pengeluaran/update') ?>" method="POST">
                <input type="hidden" name="id_pengeluaran" id="epId">
                <input type="hidden" name="week_offset" value="<?= $w ?>">
                <div class="form-group"><label>Nama Barang *</label><input type="text" name="nama_barang" id="epNama" class="form-input" required></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group"><label>Harga (Rp) *</label><input type="number" name="harga" id="epHarga" class="form-input" required min="500" step="500"></div>
                    <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" id="epTgl" class="form-input"></div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group"><label>Kategori</label>
                        <select name="kategori" id="epKat" class="form-input">
                            <option value="lauk">🍗 Lauk</option><option value="sayur">🥬 Sayur</option><option value="bahan_pokok">🍚 Bahan Pokok</option><option value="bumbu">🧂 Bumbu</option><option value="snack">🍿 Snack</option><option value="lainnya">📦 Lainnya</option>
                        </select></div>
                    <div class="form-group"><label>Catatan</label><input type="text" name="catatan" id="epCat" class="form-input"></div>
                </div>
                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('editPx')">Batal</button>
                    <button type="submit" class="btn-mp btn-brand" style="flex:2;justify-content:center">💾 Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ═══ MODAL: Edit Budget ═══ -->
<div class="mo" id="editBudget">
    <div class="mo-box">
        <div class="mo-head"><h4>✏️ Edit Budget Minggu Ini</h4><button class="mo-x" onclick="closeModal('editBudget')">&times;</button></div>
        <div class="mo-body">
            <div class="form-group"><label>Budget (Rp)</label><input type="number" id="budgetInput" class="form-input" value="<?= (int)$budget->budget_amount ?>" min="0" step="10000"></div>
            <button onclick="saveBudget()" class="btn-mp btn-brand w-full" style="justify-content:center">💾 Simpan</button>
        </div>
    </div>
</div>

<script>
function openModal(id){document.getElementById(id).classList.add('open')}
function closeModal(id){document.getElementById(id).classList.remove('open')}
document.querySelectorAll('.mo').forEach(function(m){m.addEventListener('click',function(e){if(e.target===this)this.classList.remove('open')})});
document.addEventListener('keydown',function(e){if(e.key==='Escape')document.querySelectorAll('.mo.open').forEach(function(m){m.classList.remove('open')})});

// Edit pengeluaran
function editPx(id){
    var r=document.getElementById('px-'+id);if(!r)return;
    document.getElementById('epId').value=id;
    document.getElementById('epNama').value=r.dataset.nama;
    document.getElementById('epHarga').value=r.dataset.harga;
    document.getElementById('epKat').value=r.dataset.kategori||'lainnya';
    document.getElementById('epTgl').value=r.dataset.tanggal;
    document.getElementById('epCat').value=r.dataset.catatan||'';
    openModal('editPx');
}

// Hapus pengeluaran
function hapusPx(id){
    if(!confirm('Hapus pengeluaran ini?'))return;
    var r=document.getElementById('px-'+id);
    if(r){r.style.transition='all .3s';r.style.opacity='0';r.style.transform='translateX(20px)'}
    $.post('<?=site_url("pengeluaran/hapus")?>',{id_pengeluaran:id},function(){setTimeout(function(){location.reload()},350)},'json');
}

// Budget edit
function saveBudget(){
    var amt=document.getElementById('budgetInput').value;
    $.post('<?=site_url("dapur/update-budget")?>',{id_budget:<?=(int)$budget->id_budget?>,amount:amt},function(){closeModal('editBudget');location.reload()},'json');
}

// Auto-suggest from master harga
var suggestTimer;
document.querySelector('[name="nama_barang"]').addEventListener('input',function(){
    var q=this.value.trim();clearTimeout(suggestTimer);if(q.length<2)return;
    suggestTimer=setTimeout(function(){
        $.get('<?=site_url("master-harga/search")?>?q='+encodeURIComponent(q),function(res){
            var r=(typeof res==='string')?JSON.parse(res):res;
            var dl=document.getElementById('bahanSuggest');dl.innerHTML='';
            if(r.data&&r.data.length){r.data.forEach(function(h){
                var opt=document.createElement('option');opt.value=h.nama_bahan;
                opt.setAttribute('data-harga',h.harga_satuan);dl.appendChild(opt);
            })}
        });
    },300);
});
document.querySelector('[name="nama_barang"]').addEventListener('change',function(){
    var val=this.value,opts=document.getElementById('bahanSuggest').options;
    for(var i=0;i<opts.length;i++){if(opts[i].value===val){
        var h=opts[i].getAttribute('data-harga');
        if(h)document.getElementById('addHarga').value=h;break;
    }}
});

// Fitur 4: Catatan Minggu
function toggleCatatan(){
    var d=document.getElementById('catatanDisplay'),e=document.getElementById('catatanEdit');
    if(e.style.display==='none'){e.style.display='block';d.style.display='none'}
    else{e.style.display='none';d.style.display='block'}
}
function saveCatatan(){
    var c=document.getElementById('catatanInput').value;
    $.post('<?=site_url("dapur/save-catatan")?>',{minggu_ke:<?=(int)$budget->minggu_ke?>,tahun:<?=(int)$budget->tahun?>,catatan:c},function(){location.reload()},'json');
}
</script>

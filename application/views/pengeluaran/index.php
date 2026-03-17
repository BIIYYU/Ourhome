<!-- PENGELUARAN DAPUR - with Edit -->
<style>
    .pe-row { display:flex; align-items:center; gap:10px; padding:10px 16px; border-bottom:1px solid var(--stone-100); transition:background .15s; }
    .pe-row:last-child { border-bottom:none; }
    .pe-row:hover { background:var(--stone-50); }
    .pe-icon { width:36px; height:36px; background:var(--stone-50); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0; }
    .pe-info { flex:1; min-width:0; }
    .pe-name { font-size:.88rem; font-weight:700; }
    .pe-meta { font-size:.65rem; color:var(--stone-400); font-weight:600; }
    .pe-price { font-size:.88rem; font-weight:800; color:var(--red); white-space:nowrap; }
    .pe-acts { display:flex; gap:2px; opacity:0; transition:opacity .2s; }
    .pe-row:hover .pe-acts { opacity:1; }
    .pe-btn { width:26px; height:26px; border-radius:6px; border:none; cursor:pointer; font-size:.65rem; display:flex; align-items:center; justify-content:center; background:var(--stone-100); color:var(--stone-500); transition:all .15s; }
    .pe-btn:hover { background:var(--brand-light); color:var(--brand); }
    .pe-btn.del:hover { background:#fef2f2; color:var(--red); }

    .mo { position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:500; display:none; backdrop-filter:blur(4px); }
    .mo.open { display:flex; align-items:center; justify-content:center; padding:16px; }
    .mo-box { background:#fff; border-radius:var(--radius); box-shadow:0 24px 80px rgba(0,0,0,.15); width:100%; max-width:440px; animation:fadeUp .3s var(--ease); overflow:hidden; }
    .mo-head { padding:14px 18px; border-bottom:1px solid var(--stone-100); display:flex; justify-content:space-between; align-items:center; }
    .mo-head h4 { font-size:.92rem; font-weight:700; }
    .mo-x { background:var(--stone-50); border:none; width:30px; height:30px; border-radius:8px; font-size:1.1rem; cursor:pointer; color:var(--stone-400); }
    .mo-x:hover { background:var(--stone-200); }
    .mo-body { padding:16px 18px; }
</style>

<div class="page-header d-flex justify-between items-center">
    <div>
        <h1>🍽️ Pengeluaran Dapur</h1>
        <p>Minggu <?= date('d M', strtotime($budget->tanggal_mulai)) ?> — <?= date('d M', strtotime($budget->tanggal_selesai)) ?></p>
    </div>
    <button class="btn-mp btn-brand btn-sm" onclick="openModal('addPengeluaran')">➕ Tambah</button>
</div>

<!-- Budget bar -->
<div class="mp-card anim-up mb-2">
    <div class="mp-card-body">
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; margin-bottom:10px;">
            <div><p class="fs-xs text-muted" style="font-weight:600;">🏦 Budget</p><p style="font-weight:800; font-size:.92rem;">Rp<?= number_format($budget->budget_amount, 0, ',', '.') ?></p></div>
            <div><p class="fs-xs text-muted" style="font-weight:600;">🛒 Terpakai</p><p style="font-weight:800; font-size:.92rem; color:var(--brand);">Rp<?= number_format($total, 0, ',', '.') ?></p></div>
            <div class="text-right"><p class="fs-xs text-muted" style="font-weight:600;">💰 Sisa</p><p style="font-weight:800; font-size:.92rem; color:<?= $sisa >= 0 ? 'var(--green)' : 'var(--red)' ?>;">Rp<?= number_format(abs($sisa), 0, ',', '.') ?><?= $sisa < 0 ? ' ⚠️' : '' ?></p></div>
        </div>
        <?php $pct = $budget->budget_amount > 0 ? min(100, round($total / $budget->budget_amount * 100)) : 0; ?>
        <div style="height:6px; background:var(--stone-100); border-radius:3px; overflow:hidden;">
            <div style="width:<?= $pct ?>%; height:100%; border-radius:3px; background:<?= $pct > 90 ? 'var(--red)' : ($pct > 70 ? 'var(--amber)' : 'var(--green)') ?>;"></div>
        </div>
        <p class="fs-xs text-muted text-right mt-1"><?= $pct ?>% terpakai</p>
        <?php if (($estimasi_menu ?? 0) > 0): ?>
            <p class="fs-xs mt-1" style="color:var(--sky); font-weight:600;">📅 Simulasi menu: Rp<?= number_format($estimasi_menu, 0, ',', '.') ?> <span style="opacity:.6;">(tidak pengaruh budget)</span></p>
        <?php endif; ?>
    </div>
</div>

<!-- List -->
<?php $kat_icons = ['lauk'=>'🍗','sayur'=>'🥬','bahan_pokok'=>'🍚','bumbu'=>'🧂','snack'=>'🍿','lainnya'=>'📦']; ?>
<?php if (!empty($list)): ?>
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3>📋 Riwayat Minggu Ini</h3>
        <span class="badge badge-brand"><?= count($list) ?> transaksi</span>
    </div>
    <div style="padding:0;">
        <?php foreach ($list as $p): ?>
            <div class="pe-row" id="pe-<?= $p->id_pengeluaran ?>"
                 data-nama="<?= htmlspecialchars($p->nama_barang) ?>"
                 data-harga="<?= $p->harga ?>"
                 data-kategori="<?= $p->kategori ?>"
                 data-tanggal="<?= $p->tanggal ?>"
                 data-catatan="<?= htmlspecialchars($p->catatan ?? '') ?>">
                <div class="pe-icon"><?= $kat_icons[$p->kategori] ?? '📦' ?></div>
                <div class="pe-info">
                    <p class="pe-name"><?= htmlspecialchars($p->nama_barang) ?></p>
                    <p class="pe-meta"><?= date('d M', strtotime($p->tanggal)) ?> · <?= ucfirst($p->kategori ?? 'lainnya') ?><?= $p->catatan ? ' · ' . htmlspecialchars($p->catatan) : '' ?></p>
                </div>
                <span class="pe-price">-Rp<?= number_format($p->harga, 0, ',', '.') ?></span>
                <div class="pe-acts">
                    <button class="pe-btn" onclick="editPengeluaran(<?= $p->id_pengeluaran ?>)" title="Edit">✏️</button>
                    <button class="pe-btn del" onclick="hapusPengeluaran(<?= $p->id_pengeluaran ?>)" title="Hapus">🗑</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<div class="mp-card anim-up mb-2"><div class="mp-card-body text-center" style="padding:2rem"><p style="font-size:2rem;margin-bottom:6px">📭</p><p style="font-weight:600;color:var(--stone-400)">Belum ada pengeluaran minggu ini</p></div></div>
<?php endif; ?>

<div class="d-flex gap-1 mt-2 flex-wrap" style="justify-content:center;">
    <a href="<?= site_url('belanja') ?>" class="btn-mp btn-outline btn-sm">🛒 Belanja</a>
    <a href="<?= site_url('pemasukan') ?>" class="btn-mp btn-outline btn-sm">💰 Pemasukan</a>
    <a href="<?= site_url('laporan?tab=makan') ?>" class="btn-mp btn-outline btn-sm">📊 Laporan</a>
</div>

<!-- MODAL: Tambah -->
<div class="mo" id="addPengeluaran">
    <div class="mo-box">
        <div class="mo-head"><h4>➕ Catat Pengeluaran</h4><button class="mo-x" onclick="closeModal('addPengeluaran')">&times;</button></div>
        <div class="mo-body">
            <form action="<?= site_url('pengeluaran/simpan') ?>" method="POST">
                <div class="grid-2">
                    <div class="form-group"><label>Nama Barang *</label><input type="text" name="nama_barang" class="form-input" required placeholder="Ayam, Beras, dll"></div>
                    <div class="form-group"><label>Harga (Rp) *</label><input type="number" name="harga" class="form-input" required min="0" placeholder="38000"></div>
                </div>
                <div class="grid-2">
                    <div class="form-group"><label>Kategori</label>
                        <select name="kategori" class="form-input">
                            <option value="lauk">🍗 Lauk</option><option value="sayur">🥬 Sayur</option><option value="bahan_pokok">🍚 Bahan Pokok</option>
                            <option value="bumbu">🧂 Bumbu</option><option value="snack">🍿 Snack</option><option value="lainnya">📦 Lainnya</option>
                        </select></div>
                    <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" class="form-input" value="<?= date('Y-m-d') ?>"></div>
                </div>
                <div class="form-group"><label>Catatan</label><input type="text" name="catatan" class="form-input" placeholder="(opsional)"></div>
                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('addPengeluaran')">Batal</button>
                    <button type="submit" class="btn-mp btn-brand" style="flex:2; justify-content:center">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Edit -->
<div class="mo" id="editPengeluaran">
    <div class="mo-box">
        <div class="mo-head"><h4>✏️ Edit Pengeluaran</h4><button class="mo-x" onclick="closeModal('editPengeluaran')">&times;</button></div>
        <div class="mo-body">
            <form action="<?= site_url('pengeluaran/update') ?>" method="POST">
                <input type="hidden" name="id_pengeluaran" id="eId">
                <div class="grid-2">
                    <div class="form-group"><label>Nama Barang *</label><input type="text" name="nama_barang" id="eNama" class="form-input" required></div>
                    <div class="form-group"><label>Harga (Rp) *</label><input type="number" name="harga" id="eHarga" class="form-input" required min="0"></div>
                </div>
                <div class="grid-2">
                    <div class="form-group"><label>Kategori</label>
                        <select name="kategori" id="eKat" class="form-input">
                            <option value="lauk">🍗 Lauk</option><option value="sayur">🥬 Sayur</option><option value="bahan_pokok">🍚 Bahan Pokok</option>
                            <option value="bumbu">🧂 Bumbu</option><option value="snack">🍿 Snack</option><option value="lainnya">📦 Lainnya</option>
                        </select></div>
                    <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" id="eTgl" class="form-input"></div>
                </div>
                <div class="form-group"><label>Catatan</label><input type="text" name="catatan" id="eCat" class="form-input"></div>
                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('editPengeluaran')">Batal</button>
                    <button type="submit" class="btn-mp btn-brand" style="flex:2; justify-content:center">💾 Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.mo').forEach(function(m){ m.addEventListener('click',function(e){if(e.target===this)this.classList.remove('open')}); });
document.addEventListener('keydown',function(e){ if(e.key==='Escape') document.querySelectorAll('.mo.open').forEach(function(m){m.classList.remove('open')}); });

function editPengeluaran(id) {
    var row = document.getElementById('pe-' + id);
    if (!row) return;
    document.getElementById('eId').value = id;
    document.getElementById('eNama').value = row.dataset.nama;
    document.getElementById('eHarga').value = row.dataset.harga;
    document.getElementById('eKat').value = row.dataset.kategori;
    document.getElementById('eTgl').value = row.dataset.tanggal;
    document.getElementById('eCat').value = row.dataset.catatan;
    openModal('editPengeluaran');
}

function hapusPengeluaran(id) {
    if (!confirm('Hapus pengeluaran ini?')) return;
    var row = document.getElementById('pe-' + id);
    if (row) { row.style.transition='all .3s'; row.style.opacity='0'; }
    $.post('<?= site_url("pengeluaran/hapus") ?>', {id_pengeluaran: id}, function() {
        setTimeout(function(){ location.reload(); }, 300);
    }, 'json');
}
</script>

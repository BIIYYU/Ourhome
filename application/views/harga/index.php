<!-- MASTER HARGA BAHAN -->
<style>
    .harga-table-wrap { background:#fff; border:1px solid var(--stone-200); border-radius:var(--radius); overflow:hidden; }
    .harga-table { width:100%; border-collapse:collapse; }
    .harga-table thead th {
        font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em;
        color:var(--stone-400); padding:10px 12px; background:var(--stone-50);
        border-bottom:2px solid var(--stone-100); text-align:left; white-space:nowrap;
    }
    .harga-table tbody td {
        font-size:.84rem; padding:10px 12px; border-bottom:1px solid var(--stone-100);
        vertical-align:middle;
    }
    .harga-table tbody tr { transition:background .15s; }
    .harga-table tbody tr:hover { background:var(--stone-50); }
    .harga-table tbody tr:last-child td { border-bottom:none; }

    .kat-badge {
        font-size:.6rem; font-weight:700; padding:2px 8px; border-radius:5px;
        text-transform:capitalize; display:inline-block;
    }
    .kat-protein { background:#fef2f2; color:#dc2626; }
    .kat-sayur { background:#f0fdf4; color:#16a34a; }
    .kat-bumbu { background:#fffbeb; color:#d97706; }
    .kat-bahan_pokok { background:#f0f9ff; color:#0284c7; }
    .kat-minyak { background:#fefce8; color:#a16207; }
    .kat-lainnya { background:#f5f5f4; color:#78716c; }

    .harga-val {
        font-family:'SF Mono','Fira Code',monospace; font-weight:700;
        color:var(--brand-dark); font-size:.88rem;
    }

    .row-actions { display:flex; gap:4px; }
    .row-btn {
        width:28px; height:28px; border-radius:7px; border:none;
        display:flex; align-items:center; justify-content:center;
        cursor:pointer; font-size:.7rem; transition:all .15s;
        background:var(--stone-50); color:var(--stone-500);
    }
    .row-btn:hover { background:var(--brand-light); color:var(--brand); }
    .row-btn.btn-del:hover { background:var(--red-soft); color:var(--red); }

    .inline-edit { display:none; }
    .inline-edit.active { display:table-row; }
    .inline-edit td { background:var(--brand-light) !important; }
    .inline-edit input, .inline-edit select {
        font-family:var(--font); font-size:.82rem; padding:5px 8px;
        border:1.5px solid var(--stone-300); border-radius:6px; width:100%;
    }
    .inline-edit input:focus, .inline-edit select:focus {
        outline:none; border-color:var(--brand); box-shadow:0 0 0 2px rgba(232,93,38,.1);
    }

    .summary-cards { display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:10px; margin-bottom:16px; }
    .sc-item { background:#fff; border:1px solid var(--stone-200); border-radius:var(--radius-sm); padding:12px 14px; text-align:center; }
    .sc-item .sc-val { font-size:1.2rem; font-weight:800; color:var(--stone-800); }
    .sc-item .sc-label { font-size:.62rem; font-weight:600; color:var(--stone-400); text-transform:uppercase; letter-spacing:.04em; margin-top:2px; }

    .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:500; display:none; backdrop-filter:blur(4px); }
    .modal-overlay.active { display:flex; align-items:center; justify-content:center; padding:20px; }
    .modal-box { background:#fff; border-radius:var(--radius); box-shadow:0 24px 80px rgba(0,0,0,.15); width:100%; max-width:440px; animation:fadeUp .3s var(--ease); }
    .modal-head { padding:14px 18px; border-bottom:1px solid var(--stone-100); display:flex; justify-content:space-between; align-items:center; }
    .modal-head h4 { font-size:.95rem; font-weight:700; }
    .modal-close { background:var(--stone-50); border:none; width:30px; height:30px; border-radius:8px; font-size:1.2rem; cursor:pointer; color:var(--stone-400); display:flex; align-items:center; justify-content:center; }
    .modal-close:hover { background:var(--stone-200); color:var(--stone-800); }
    .modal-body-m { padding:16px 18px; }
</style>

<div class="page-header d-flex justify-between items-center">
    <div>
        <h1>🏷️ Master Harga Bahan</h1>
        <p>Kelola harga bahan belanjaan</p>
    </div>
    <div class="d-flex gap-1">
        <a href="<?= site_url('setup') ?>" class="btn-mp btn-outline btn-sm">⚙️ Ubah Budget</a>
        <button class="btn-mp btn-brand btn-sm" onclick="openAdd()">➕ Tambah</button>
    </div>
</div>

<!-- Summary -->
<?php
$total_items = count($list);
$kat_counts = [];
$avg_price = 0;
foreach ($list as $h) {
    $kat_counts[$h->kategori_bahan ?? 'lainnya'] = ($kat_counts[$h->kategori_bahan ?? 'lainnya'] ?? 0) + 1;
    $avg_price += $h->harga_satuan;
}
$avg_price = $total_items > 0 ? $avg_price / $total_items : 0;
$kat_icons = ['protein'=>'🍗','sayur'=>'🥬','bumbu'=>'🧂','bahan_pokok'=>'🍚','minyak'=>'🫗','lainnya'=>'📦'];
?>

<div class="summary-cards">
    <div class="sc-item"><div class="sc-val"><?= $total_items ?></div><div class="sc-label">Total Item</div></div>
    <div class="sc-item"><div class="sc-val"><?= count($kat_counts) ?></div><div class="sc-label">Kategori</div></div>
    <div class="sc-item"><div class="sc-val">Rp<?= number_format($avg_price, 0, ',', '.') ?></div><div class="sc-label">Rata-rata Harga</div></div>
</div>

<!-- Search + Filter -->
<div class="d-flex gap-1 mb-2 flex-wrap">
    <div style="position:relative; flex:1; min-width:200px;">
        <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); font-size:.9rem;">🔍</span>
        <input type="text" id="searchHarga" class="form-input" placeholder="Cari bahan..."
            style="padding-left:34px; font-size:.85rem;">
    </div>
    <div style="display:flex; gap:4px; flex-wrap:wrap;">
        <a href="<?= site_url('master-harga') ?>"
            class="btn-mp btn-sm <?= !$selected_kat ? 'btn-brand' : 'btn-outline' ?>">Semua</a>
        <?php foreach ($kategori_list as $kl): ?>
            <a href="<?= site_url('master-harga') ?>?kategori=<?= $kl->kategori_bahan ?>"
                class="btn-mp btn-sm <?= $selected_kat == $kl->kategori_bahan ? 'btn-brand' : 'btn-outline' ?>">
                <?= $kat_icons[$kl->kategori_bahan] ?? '📦' ?> <?= ucfirst($kl->kategori_bahan) ?>
                <span style="font-size:.6rem; opacity:.7;">(<?= $kl->total ?>)</span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Table -->
<?php if (empty($list)): ?>
    <div class="mp-card">
        <div class="mp-card-body text-center" style="padding:3rem 1rem">
            <p style="font-size:3rem; margin-bottom:8px">🏷️</p>
            <p style="font-weight:700; color:var(--stone-600)">Belum ada data harga</p>
            <p class="fs-sm text-muted">Tambahkan harga bahan belanjaan.</p>
            <button class="btn-mp btn-brand btn-sm mt-2" onclick="openAdd()">➕ Tambah Bahan</button>
        </div>
    </div>
<?php else: ?>
    <div class="harga-table-wrap">
        <table class="harga-table" id="hargaTable">
            <thead>
                <tr>
                    <th style="width:30px">No</th>
                    <th>Nama Bahan</th>
                    <th>Harga</th>
                    <th>Satuan</th>
                    <th>Kategori</th>
                    <th>Catatan</th>
                    <th style="width:70px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $i => $h): ?>
                    <tr class="harga-row" data-id="<?= $h->id_harga ?>" data-nama="<?= htmlspecialchars(strtolower($h->nama_bahan)) ?>">
                        <td style="text-align:center; color:var(--stone-400); font-weight:600;"><?= $i + 1 ?></td>
                        <td style="font-weight:700;"><?= htmlspecialchars($h->nama_bahan) ?></td>
                        <td><span class="harga-val">Rp<?= number_format($h->harga_satuan, 0, ',', '.') ?></span></td>
                        <td style="color:var(--stone-500);"><?= htmlspecialchars($h->satuan) ?></td>
                        <td>
                            <span class="kat-badge kat-<?= $h->kategori_bahan ?? 'lainnya' ?>">
                                <?= $kat_icons[$h->kategori_bahan] ?? '📦' ?> <?= ucfirst($h->kategori_bahan ?? 'lainnya') ?>
                            </span>
                        </td>
                        <td style="font-size:.78rem; color:var(--stone-400);"><?= htmlspecialchars($h->catatan ?? '') ?></td>
                        <td>
                            <div class="row-actions">
                                <button class="row-btn" onclick="openEdit(<?= $h->id_harga ?>, '<?= htmlspecialchars(addslashes($h->nama_bahan)) ?>', <?= $h->harga_satuan ?>, '<?= htmlspecialchars(addslashes($h->satuan)) ?>', '<?= $h->kategori_bahan ?>', '<?= htmlspecialchars(addslashes($h->catatan ?? '')) ?>')" title="Edit">✏️</button>
                                <button class="row-btn btn-del" onclick="hapusHarga(<?= $h->id_harga ?>, '<?= htmlspecialchars(addslashes($h->nama_bahan)) ?>')" title="Hapus">🗑</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="fs-xs text-muted mt-1 text-right">Terakhir diupdate: <?= date('d M Y H:i') ?></p>
<?php endif; ?>


<!-- MODAL: Add/Edit Harga -->
<div class="modal-overlay" id="hargaModal">
    <div class="modal-box">
        <div class="modal-head">
            <h4 id="hargaFormTitle">➕ Tambah Bahan Baru</h4>
            <button class="modal-close" onclick="closeHM()">&times;</button>
        </div>
        <div class="modal-body-m">
            <form id="hargaForm" method="POST">
                <input type="hidden" name="id_harga" id="h_id" value="">

                <div class="form-group">
                    <label>Nama Bahan *</label>
                    <input type="text" name="nama_bahan" id="h_nama" class="form-input" required
                        placeholder="cth: Ayam, Bawang Merah, Beras">
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Harga (Rp) *</label>
                        <input type="number" name="harga_satuan" id="h_harga" class="form-input"
                            required min="0" step="100" placeholder="15000">
                    </div>
                    <div class="form-group">
                        <label>Satuan *</label>
                        <input type="text" name="satuan" id="h_satuan" class="form-input"
                            required placeholder="gram, butir, kg, ikat" list="satuanList">
                        <datalist id="satuanList">
                            <option value="gram">
                            <option value="kg">
                            <option value="butir">
                            <option value="buah">
                            <option value="ikat">
                            <option value="papan">
                            <option value="siung">
                            <option value="batang">
                            <option value="sdm">
                            <option value="sdt">
                            <option value="bungkus">
                            <option value="botol">
                            <option value="liter">
                            <option value="porsi">
                        </datalist>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_bahan" id="h_kat" class="form-input">
                        <option value="protein">🍗 Protein (Ayam, Ikan, Telur, dll)</option>
                        <option value="sayur">🥬 Sayur</option>
                        <option value="bumbu">🧂 Bumbu</option>
                        <option value="bahan_pokok">🍚 Bahan Pokok (Beras, Mie, dll)</option>
                        <option value="minyak">🫗 Minyak & Santan</option>
                        <option value="lainnya">📦 Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Catatan (opsional)</label>
                    <input type="text" name="catatan" id="h_catatan" class="form-input"
                        placeholder="cth: Harga di pasar tradisional">
                </div>

                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeHM()">Batal</button>
                    <button type="submit" class="btn-mp btn-brand" style="flex:2; justify-content:center">
                        💾 <span id="h_btnText">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
// Modal
function openHM() { document.getElementById('hargaModal').classList.add('active'); }
function closeHM() { document.getElementById('hargaModal').classList.remove('active'); }
document.getElementById('hargaModal').addEventListener('click', function(e) { if (e.target===this) closeHM(); });

// Add
function openAdd() {
    document.getElementById('hargaFormTitle').textContent = '➕ Tambah Bahan Baru';
    document.getElementById('h_btnText').textContent = 'Simpan';
    document.getElementById('hargaForm').action = '<?= site_url("master-harga/simpan") ?>';
    document.getElementById('h_id').value = '';
    document.getElementById('h_nama').value = '';
    document.getElementById('h_harga').value = '';
    document.getElementById('h_satuan').value = '';
    document.getElementById('h_kat').value = 'bumbu';
    document.getElementById('h_catatan').value = '';
    openHM();
    document.getElementById('h_nama').focus();
}

// Edit
function openEdit(id, nama, harga, satuan, kat, catatan) {
    document.getElementById('hargaFormTitle').textContent = '✏️ Edit: ' + nama;
    document.getElementById('h_btnText').textContent = 'Update';
    document.getElementById('hargaForm').action = '<?= site_url("master-harga/update") ?>';
    document.getElementById('h_id').value = id;
    document.getElementById('h_nama').value = nama;
    document.getElementById('h_harga').value = harga;
    document.getElementById('h_satuan').value = satuan;
    document.getElementById('h_kat').value = kat || 'lainnya';
    document.getElementById('h_catatan').value = catatan || '';
    openHM();
}

// Delete
function hapusHarga(id, nama) {
    if (!confirm('Hapus "' + nama + '" dari master harga?')) return;
    $.post('<?= site_url("master-harga/hapus") ?>', {id_harga: id}, function() {
        var row = document.querySelector('.harga-row[data-id="' + id + '"]');
        if (row) { row.style.transition='all .3s'; row.style.opacity='0'; setTimeout(function(){row.remove()},300); }
    }, 'json');
}

// Search
document.getElementById('searchHarga').addEventListener('input', function() {
    var q = this.value.toLowerCase().trim();
    document.querySelectorAll('.harga-row').forEach(function(row) {
        row.style.display = row.dataset.nama.indexOf(q) > -1 ? '' : 'none';
    });
});

document.addEventListener('keydown', function(e) { if (e.key==='Escape') closeHM(); });
</script>

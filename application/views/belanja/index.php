<!-- BELANJA + PENGELUARAN LAIN - Monthly, Date-Grouped -->
<style>
    .mn{display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:14px}
    .mn a,.mn span{font-size:.78rem;font-weight:700;padding:6px 14px;border-radius:8px;text-decoration:none;transition:all .2s}
    .mn a{color:var(--stone-500);border:1px solid var(--rose-200);background:#fff}
    .mn a:hover{border-color:var(--brand);color:var(--brand);background:var(--brand-light)}
    .mn .mn-cur{background:var(--brand);color:#fff;border:none;font-size:.65rem;padding:4px 10px;border-radius:6px}

    .budget-bar{border-radius:var(--radius);padding:20px 24px;margin-bottom:16px;color:#fff;position:relative;overflow:hidden}
    .budget-bar.bb-belanja{background:linear-gradient(135deg, #f078a0, var(--brand))}
    .budget-bar.bb-lain{background:linear-gradient(135deg, #d14a76, #a83660)}
    .bb-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-top:12px}
    .bb-box{background:rgba(255,255,255,.15);border-radius:10px;padding:8px 12px}
    .bb-box .bl{font-size:.6rem;opacity:.7;font-weight:600}
    .bb-box .bv{font-size:.95rem;font-weight:800}
    .bb-edit{background:none;border:none;cursor:pointer;font-size:.72rem;color:rgba(255,255,255,.7);text-decoration:underline;font-family:inherit;font-weight:600}
    .bb-edit:hover{color:#fff}
    .bb-progress{height:6px;background:rgba(255,255,255,.2);border-radius:3px;margin-top:10px;overflow:hidden}
    .bb-progress-fill{height:100%;border-radius:3px;background:#fff;transition:width .5s}

    .ix-row{display:flex;align-items:center;gap:10px;padding:10px 16px;border-bottom:1px solid var(--rose-100);transition:all .2s;padding-left:36px}
    .ix-row:hover{background:var(--brand-light)}.ix-row:last-child{border-bottom:none}
    .ix-icon{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0}
    .ix-info{flex:1;min-width:0}
    .ix-name{font-size:.85rem;font-weight:700;color:var(--stone-800)}
    .ix-sub{font-size:.65rem;color:var(--stone-400);font-weight:600}
    .ix-act{display:flex;gap:2px;opacity:0;transition:opacity .15s}
    .ix-row:hover .ix-act{opacity:1}
    .ix-btn{width:26px;height:26px;border-radius:6px;border:none;background:transparent;cursor:pointer;font-size:.65rem;display:flex;align-items:center;justify-content:center;transition:all .15s}
    .ix-btn:hover{background:var(--rose-100)}.ix-btn.del:hover{background:var(--red-soft);color:var(--red)}
    .pl-tag{font-size:.55rem;font-weight:700;padding:2px 6px;border-radius:4px;background:var(--stone-100);color:var(--stone-500)}
    .pl-tag.rutin{background:var(--sky-soft);color:var(--sky)}

    .mo{position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:500;display:none;backdrop-filter:blur(4px)}
    .mo.open{display:flex;align-items:center;justify-content:center;padding:16px}
    .mo-box{background:#fff;border-radius:var(--radius);box-shadow:0 24px 80px rgba(0,0,0,.15);width:100%;max-width:440px;overflow:hidden}
    .mo-head{padding:14px 18px;border-bottom:1px solid var(--rose-100);display:flex;justify-content:space-between;align-items:center}
    .mo-head h4{font-size:.92rem;font-weight:800}
    .mo-x{background:var(--stone-100);border:none;width:30px;height:30px;border-radius:8px;font-size:1.1rem;cursor:pointer;color:var(--stone-400)}.mo-x:hover{background:var(--stone-200)}
    .mo-body{padding:16px 18px}
</style>

<?php
$nama_bulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$nama_hari = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
$bb = $budget_bln;
$sisa_belanja = (float)$bb->budget_belanja - $total_belanja;
$sisa_lain = (float)$bb->budget_lainnya - $total_lain;
$pct_belanja = (float)$bb->budget_belanja > 0 ? min(100, round($total_belanja / (float)$bb->budget_belanja * 100)) : 0;
$pct_lain = (float)$bb->budget_lainnya > 0 ? min(100, round($total_lain / (float)$bb->budget_lainnya * 100)) : 0;
$bel_icons = ['protein'=>['🍗','#fff0f2'],'sayur'=>['🥬','#edfcf2'],'bumbu'=>['🧂','#f5f0ff'],'bahan_pokok'=>['🍚','#fef8ec'],'minyak'=>['🫗','#fef8ec'],'lainnya'=>['📦','#f8f6f4']];
$kat_lain_icons = ['tagihan'=>['💡','#fef2f2'],'asuransi'=>['🛡️','#eef7ff'],'peralatan'=>['🔧','#f5f0ff'],'transportasi'=>['🚗','#fef8ec'],'pendidikan'=>['📚','#edfcf2'],'hiburan'=>['🎬','#fef2f2'],'kesehatan'=>['🏥','#eef7ff'],'lainnya'=>['📦','#f8f6f4']];

// Group belanja by date
$bel_grouped = [];
foreach ($items as $it) {
    $tgl = date('Y-m-d', strtotime($it->created_at));
    if (!isset($bel_grouped[$tgl])) $bel_grouped[$tgl] = [];
    $bel_grouped[$tgl][] = $it;
}
krsort($bel_grouped);

// Group pengeluaran lain by date
$pl_grouped = [];
foreach ($pengeluaran_lain as $pl) {
    $tgl = $pl->tanggal;
    if (!isset($pl_grouped[$tgl])) $pl_grouped[$tgl] = [];
    $pl_grouped[$tgl][] = $pl;
}
krsort($pl_grouped);
?>

<!-- Header -->
<div class="d-flex justify-between items-center" style="margin-bottom:14px">
    <div>
        <h1 style="font-family:var(--font);font-size:1.5rem;font-weight:900;letter-spacing:-.02em">🛒 Daftar Belanja</h1>
        <p class="fs-sm text-muted"><?= $nama_bulan[$bulan] ?> <?= $tahun ?></p>
    </div>
    <div class="d-flex gap-1">
        <button class="btn-mp btn-brand btn-sm" onclick="openModal('addBelanja')">➕ Belanja</button>
        <button class="btn-mp btn-outline btn-sm" onclick="openModal('addLain')" style="border-color:var(--brand-dark);color:var(--brand-dark)">💸 Pengeluaran</button>
    </div>
</div>

<!-- Month Nav -->
<?php
$pm=$bulan-1;$py=$tahun;if($pm<1){$pm=12;$py--;}
$nm=$bulan+1;$ny=$tahun;if($nm>12){$nm=1;$ny++;}
?>
<div class="mn anim-up">
    <a href="<?= site_url('belanja?bulan='.$pm.'&tahun='.$py) ?>">← <?= substr($nama_bulan[$pm],0,3) ?></a>
    <?php if (!$is_current): ?>
        <a href="<?= site_url('belanja') ?>" class="mn-cur">Bulan Ini</a>
    <?php else: ?>
        <span class="mn-cur">📍 <?= $nama_bulan[$bulan] ?> <?= $tahun ?></span>
    <?php endif; ?>
    <a href="<?= site_url('belanja?bulan='.$nm.'&tahun='.$ny) ?>"><?= substr($nama_bulan[$nm],0,3) ?> →</a>
</div>

<!-- ═══ BUDGET BELANJA ═══ -->
<div class="budget-bar bb-belanja anim-up">
    <div class="d-flex justify-between items-center">
        <div>
            <p style="font-size:.65rem;opacity:.7;font-weight:600;text-transform:uppercase;letter-spacing:.06em">Budget Belanja Bulanan</p>
            <p style="font-size:1.6rem;font-weight:800">Rp<?= number_format($bb->budget_belanja, 0, ',', '.') ?></p>
            <button class="bb-edit" onclick="editBudgetBln('belanja')">✏️ Edit Budget</button>
        </div>
        <div style="text-align:right"><p style="font-size:1.8rem;font-weight:900"><?= $pct_belanja ?>%</p><p style="font-size:.65rem;opacity:.7">terpakai</p></div>
    </div>
    <div class="bb-grid">
        <div class="bb-box"><p class="bl">🛒 Terpakai</p><p class="bv">Rp<?= number_format($total_belanja, 0, ',', '.') ?></p></div>
        <div class="bb-box"><p class="bl">💰 Sisa</p><p class="bv" <?= $sisa_belanja<0?'style="color:#fca5a5"':'' ?>>Rp<?= number_format(abs($sisa_belanja), 0, ',', '.') ?></p></div>
        <div class="bb-box"><p class="bl">📦 Item</p><p class="bv"><?= count($items) ?></p></div>
    </div>
    <div class="bb-progress"><div class="bb-progress-fill" style="width:<?= $pct_belanja ?>%"></div></div>
</div>

<!-- ═══ BELANJA LIST (date-grouped) ═══ -->
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3>🛒 Belanja Bulanan</h3>
        <button class="btn-mp btn-brand btn-sm" onclick="openModal('addBelanja')" style="font-size:.65rem;padding:3px 8px">+ Tambah</button>
    </div>
    <?php if (empty($items)): ?>
    <div class="mp-card-body text-center" style="padding:2rem">
        <p style="font-size:2rem;margin-bottom:6px">🛒</p>
        <p style="font-weight:700;color:var(--stone-500);margin-bottom:4px">Belum ada belanja bulan ini</p>
        <button class="btn-mp btn-brand btn-sm" onclick="openModal('addBelanja')">➕ Tambah</button>
    </div>
    <?php else: ?>
    <div style="padding:0">
        <?php foreach ($bel_grouped as $tgl => $date_items):
            $total_tgl = array_sum(array_map(fn($i)=>(float)$i->estimasi_harga, $date_items));
            $hari = $nama_hari[date('l', strtotime($tgl))] ?? '';
            $is_today = ($tgl == date('Y-m-d'));
        ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 16px;background:<?= $is_today?'var(--brand-light)':'var(--stone-50)' ?>;border-bottom:1px solid var(--rose-100)">
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:.75rem"><?= $is_today?'📍':'📅' ?></span>
                <span style="font-size:.8rem;font-weight:800;color:<?= $is_today?'var(--brand)':'var(--stone-700)' ?>"><?= $hari ?>, <?= date('d M Y', strtotime($tgl)) ?></span>
                <?php if ($is_today): ?><span style="font-size:.55rem;font-weight:700;background:var(--brand);color:#fff;padding:2px 6px;border-radius:4px">Hari Ini</span><?php endif; ?>
            </div>
            <span style="font-size:.72rem;font-weight:800;color:#fff;background:var(--brand);padding:4px 12px;border-radius:20px">Rp<?= number_format($total_tgl, 0, ',', '.') ?></span>
        </div>
        <?php foreach ($date_items as $item):
            $ki = $bel_icons[$item->kategori_item ?? 'lainnya'] ?? $bel_icons['lainnya'];
        ?>
        <div class="ix-row" id="bl-<?= $item->id_belanja ?>"
            data-nama="<?= htmlspecialchars($item->nama_item) ?>"
            data-jumlah="<?= $item->jumlah ?>"
            data-satuan="<?= htmlspecialchars($item->satuan) ?>"
            data-harga="<?= $item->estimasi_harga ?>"
            data-kat="<?= $item->kategori_item ?>"
            data-tgl="<?= date('Y-m-d', strtotime($item->created_at)) ?>">
            <div class="ix-icon" style="background:<?= $ki[1] ?>"><?= $ki[0] ?></div>
            <div class="ix-info">
                <p class="ix-name"><?= htmlspecialchars($item->nama_item) ?></p>
                <p class="ix-sub"><?= $item->jumlah ?> <?= htmlspecialchars($item->satuan) ?><?= $item->kategori_item ? ' · '.ucfirst($item->kategori_item) : '' ?> · <span style="color:var(--stone-600);font-weight:700">Rp<?= number_format($item->estimasi_harga, 0, ',', '.') ?></span></p>
            </div>
            <div class="ix-act">
                <button class="ix-btn" onclick="editBelanja(<?= $item->id_belanja ?>)">✏️</button>
                <button class="ix-btn del" onclick="hapusItem(<?= $item->id_belanja ?>)">🗑</button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div style="padding:10px 16px;border-top:1px solid var(--rose-100);display:flex;justify-content:space-between;align-items:center">
        <span class="fs-sm" style="font-weight:700;color:var(--stone-500)">Total <?= count($items) ?> item</span>
        <span style="font-size:.95rem;font-weight:800;color:var(--brand)">Rp<?= number_format($total_belanja, 0, ',', '.') ?></span>
    </div>
    <?php endif; ?>
</div>

<!-- ═══ BUDGET PENGELUARAN LAIN ═══ -->
<div class="budget-bar bb-lain anim-up">
    <div class="d-flex justify-between items-center">
        <div>
            <p style="font-size:.65rem;opacity:.7;font-weight:600;text-transform:uppercase;letter-spacing:.06em">Budget Pengeluaran Lain</p>
            <p style="font-size:1.6rem;font-weight:800">Rp<?= number_format($bb->budget_lainnya, 0, ',', '.') ?></p>
            <button class="bb-edit" onclick="editBudgetBln('lainnya')">✏️ Edit Budget</button>
        </div>
        <div style="text-align:right"><p style="font-size:1.8rem;font-weight:900"><?= $pct_lain ?>%</p><p style="font-size:.65rem;opacity:.7">terpakai</p></div>
    </div>
    <div class="bb-grid">
        <div class="bb-box"><p class="bl">💸 Terpakai</p><p class="bv">Rp<?= number_format($total_lain, 0, ',', '.') ?></p></div>
        <div class="bb-box"><p class="bl">💰 Sisa</p><p class="bv" <?= $sisa_lain<0?'style="color:#fca5a5"':'' ?>>Rp<?= number_format(abs($sisa_lain), 0, ',', '.') ?></p></div>
        <div class="bb-box"><p class="bl">📋 Transaksi</p><p class="bv"><?= count($pengeluaran_lain) ?></p></div>
    </div>
    <div class="bb-progress"><div class="bb-progress-fill" style="width:<?= $pct_lain ?>%;background:rgba(255,255,255,.8)"></div></div>
</div>

<!-- ═══ PENGELUARAN LAIN LIST (date-grouped) ═══ -->
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3>💸 Pengeluaran Lain</h3>
        <button class="btn-mp btn-outline btn-sm" onclick="openModal('addLain')" style="font-size:.65rem;padding:3px 8px;border-color:var(--brand-dark);color:var(--brand-dark)">+ Tambah</button>
    </div>
    <?php if (empty($pengeluaran_lain)): ?>
    <div class="mp-card-body text-center" style="padding:1.5rem">
        <p style="font-size:1.5rem;margin-bottom:4px">💸</p>
        <p class="fs-sm text-muted">Belum ada pengeluaran lain.</p>
    </div>
    <?php else: ?>
    <div style="padding:0">
        <?php foreach ($pl_grouped as $tgl => $date_items):
            $total_tgl = array_sum(array_map(fn($p)=>(float)$p->jumlah, $date_items));
            $hari = $nama_hari[date('l', strtotime($tgl))] ?? '';
            $is_today = ($tgl == date('Y-m-d'));
        ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 16px;background:<?= $is_today?'var(--brand-light)':'var(--stone-50)' ?>;border-bottom:1px solid var(--rose-100)">
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:.75rem"><?= $is_today?'📍':'📅' ?></span>
                <span style="font-size:.8rem;font-weight:800;color:<?= $is_today?'var(--brand)':'var(--stone-700)' ?>"><?= $hari ?>, <?= date('d M Y', strtotime($tgl)) ?></span>
            </div>
            <span style="font-size:.72rem;font-weight:800;color:#fff;background:var(--brand-dark);padding:4px 12px;border-radius:20px">Rp<?= number_format($total_tgl, 0, ',', '.') ?></span>
        </div>
        <?php foreach ($date_items as $pl):
            $ki = $kat_lain_icons[$pl->kategori ?? 'lainnya'] ?? $kat_lain_icons['lainnya'];
        ?>
        <div class="ix-row" id="pl-<?= $pl->id_pengeluaran_lain ?>"
            data-nama="<?= htmlspecialchars($pl->nama) ?>"
            data-jumlah="<?= $pl->jumlah ?>"
            data-kategori="<?= $pl->kategori ?>"
            data-tanggal="<?= $pl->tanggal ?>"
            data-catatan="<?= htmlspecialchars($pl->catatan ?? '') ?>"
            data-rutin="<?= $pl->is_rutin ?>">
            <div class="ix-icon" style="background:<?= $ki[1] ?>"><?= $ki[0] ?></div>
            <div class="ix-info">
                <p class="ix-name"><?= htmlspecialchars($pl->nama) ?></p>
                <p class="ix-sub">
                    <span class="pl-tag"><?= ucfirst($pl->kategori ?? 'lainnya') ?></span>
                    <?php if ($pl->is_rutin): ?> <span class="pl-tag rutin">🔁 Rutin</span><?php endif; ?>
                    <?= $pl->catatan ? ' · '.htmlspecialchars($pl->catatan) : '' ?>
                    · <span style="color:var(--stone-600);font-weight:700">Rp<?= number_format($pl->jumlah, 0, ',', '.') ?></span>
                </p>
            </div>
            <div class="ix-act">
                <button class="ix-btn" onclick="editLain(<?= $pl->id_pengeluaran_lain ?>)">✏️</button>
                <button class="ix-btn del" onclick="hapusLain(<?= $pl->id_pengeluaran_lain ?>)">🗑</button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div style="padding:10px 16px;border-top:1px solid var(--rose-100);display:flex;justify-content:space-between;align-items:center">
        <span class="fs-sm" style="font-weight:700;color:var(--stone-500)">Total <?= count($pengeluaran_lain) ?> transaksi</span>
        <span style="font-size:.95rem;font-weight:800;color:var(--brand-dark)">Rp<?= number_format($total_lain, 0, ',', '.') ?></span>
    </div>
    <?php endif; ?>
</div>

<!-- ═══ FITUR 5: Template Belanja ═══ -->
<?php if (!empty($templates)): ?>
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3 style="font-size:.88rem">📋 Template Belanja</h3>
    </div>
    <div style="padding:0">
        <?php foreach ($templates as $tpl): ?>
        <div class="ix-row" style="padding-left:16px" id="tpl-<?= $tpl->id ?>">
            <span style="font-size:1rem">📋</span>
            <div class="ix-info">
                <p class="ix-name"><?= htmlspecialchars($tpl->nama_template) ?></p>
                <p class="ix-sub">Dibuat <?= date('d M Y', strtotime($tpl->created_at)) ?></p>
            </div>
            <form action="<?= site_url('template/apply') ?>" method="POST" style="display:inline">
                <input type="hidden" name="id_template" value="<?= $tpl->id ?>">
                <button type="submit" class="btn-mp btn-brand btn-sm" style="font-size:.65rem;padding:4px 10px" onclick="return confirm('Terapkan template ini? Item akan ditambahkan ke belanja bulan ini.')">⚡ Terapkan</button>
            </form>
            <button class="ix-btn del" onclick="hapusTemplate(<?= $tpl->id ?>)" style="opacity:1">🗑</button>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($items)): ?>
<div style="text-align:center;margin-bottom:12px">
    <button class="btn-mp btn-outline btn-sm" onclick="saveCurrentAsTemplate()" style="font-size:.7rem">📋 Simpan Belanja Ini Sebagai Template</button>
</div>
<?php endif; ?>

<!-- Shortcuts -->
<div class="d-flex gap-1" style="justify-content:center;flex-wrap:wrap">
    <a href="<?= site_url('rencana') ?>" class="btn-mp btn-outline btn-sm">📅 Menu Mingguan</a>
    <a href="<?= site_url('pemasukan?bulan='.$bulan.'&tahun='.$tahun) ?>" class="btn-mp btn-outline btn-sm">💰 Pemasukan</a>
    <a href="<?= site_url('laporan?tab=saldo&bulan='.$bulan.'&tahun='.$tahun) ?>" class="btn-mp btn-outline btn-sm">📊 Laporan</a>
</div>

<!-- ═══ MODALS ═══ -->

<!-- Tambah Belanja -->
<div class="mo" id="addBelanja"><div class="mo-box">
    <div class="mo-head"><h4>➕ Tambah Belanja</h4><button class="mo-x" onclick="closeModal('addBelanja')">&times;</button></div>
    <div class="mo-body">
        <form action="<?= site_url('belanja/tambah') ?>" method="POST">
            <input type="hidden" name="bulan" value="<?= $bulan ?>"><input type="hidden" name="tahun" value="<?= $tahun ?>">
            <div class="form-group"><label>Nama Bahan *</label><input type="text" name="nama_item" class="form-input" required placeholder="cth: Ayam, Beras" id="addNama" list="bahanSuggest"><datalist id="bahanSuggest"></datalist></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group"><label>Jumlah</label><input type="number" name="jumlah" class="form-input" value="1" min="0.5" step="0.5"></div>
                <div class="form-group"><label>Satuan</label><input type="text" name="satuan" class="form-input" placeholder="kg, butir" id="addSatuan" list="satuanList"><datalist id="satuanList"><option value="kg"><option value="gram"><option value="butir"><option value="buah"><option value="ikat"><option value="liter"><option value="bungkus"></datalist></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px">
                <div class="form-group"><label>Harga (Rp)</label><input type="number" name="estimasi_harga" class="form-input" min="0" step="500" id="addHarga" placeholder="5000"></div>
                <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal_belanja" class="form-input" value="<?= date('Y-m-d') ?>"></div>
                <div class="form-group"><label>Kategori</label><select name="kategori_item" class="form-input" id="addKat"><option value="">Pilih...</option><option value="protein">🍗 Protein</option><option value="sayur">🥬 Sayur</option><option value="bumbu">🧂 Bumbu</option><option value="bahan_pokok">🍚 Bahan Pokok</option><option value="minyak">🫗 Minyak</option><option value="lainnya">📦 Lainnya</option></select></div>
            </div>
            <div class="d-flex gap-1 mt-2"><button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('addBelanja')">Batal</button><button type="submit" class="btn-mp btn-brand" style="flex:2;justify-content:center">💾 Simpan</button></div>
        </form>
    </div>
</div></div>

<!-- Tambah Pengeluaran Lain -->
<div class="mo" id="addLain"><div class="mo-box">
    <div class="mo-head"><h4>💸 Tambah Pengeluaran Lain</h4><button class="mo-x" onclick="closeModal('addLain')">&times;</button></div>
    <div class="mo-body">
        <form action="<?= site_url('pengeluaran-lain/simpan') ?>" method="POST">
            <input type="hidden" name="bulan" value="<?= $bulan ?>"><input type="hidden" name="tahun" value="<?= $tahun ?>">
            <div class="form-group"><label>Nama *</label><input type="text" name="nama" class="form-input" required placeholder="cth: Listrik, BPJS" list="namaLainList"><datalist id="namaLainList"><option value="Listrik PLN"><option value="BPJS Kesehatan"><option value="WiFi/Internet"><option value="Air PDAM"><option value="Gas LPG"><option value="Sewa Rumah"><option value="Cicilan"><option value="Bensin/BBM"></datalist></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group"><label>Jumlah (Rp) *</label><input type="number" name="jumlah" class="form-input" required min="500" step="500" placeholder="150000"></div>
                <div class="form-group"><label>Tanggal *</label><input type="date" name="tanggal" class="form-input" value="<?= date('Y-m-d') ?>" required></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group"><label>Kategori</label><select name="kategori" class="form-input"><option value="tagihan">💡 Tagihan</option><option value="asuransi">🛡️ Asuransi</option><option value="peralatan">🔧 Peralatan</option><option value="transportasi">🚗 Transportasi</option><option value="pendidikan">📚 Pendidikan</option><option value="kesehatan">🏥 Kesehatan</option><option value="hiburan">🎬 Hiburan</option><option value="lainnya">📦 Lainnya</option></select></div>
                <div class="form-group"><label>Catatan</label><input type="text" name="catatan" class="form-input" placeholder="(opsional)"></div>
            </div>
            <div class="form-group"><label style="display:flex;align-items:center;gap:6px;cursor:pointer"><input type="checkbox" name="is_rutin" value="1" style="accent-color:var(--sky);width:16px;height:16px"><span>🔁 Pengeluaran rutin</span></label></div>
            <div class="d-flex gap-1 mt-2"><button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('addLain')">Batal</button><button type="submit" class="btn-mp btn-brand" style="flex:2;justify-content:center;background:var(--brand-dark);border-color:var(--brand-dark)">💾 Simpan</button></div>
        </form>
    </div>
</div></div>

<!-- Edit Belanja -->
<div class="mo" id="editBelanja"><div class="mo-box">
    <div class="mo-head"><h4>✏️ Edit Belanja</h4><button class="mo-x" onclick="closeModal('editBelanja')">&times;</button></div>
    <div class="mo-body">
        <form action="<?= site_url('belanja/update') ?>" method="POST">
            <input type="hidden" name="id_belanja" id="ebId">
            <div class="form-group"><label>Nama *</label><input type="text" name="nama_item" id="ebNama" class="form-input" required></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group"><label>Jumlah</label><input type="number" name="jumlah" id="ebJumlah" class="form-input" min="0.5" step="0.5"></div>
                <div class="form-group"><label>Satuan</label><input type="text" name="satuan" id="ebSatuan" class="form-input"></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group"><label>Harga (Rp)</label><input type="number" name="estimasi_harga" id="ebHarga" class="form-input" min="0" step="500"></div>
                <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal_belanja" id="ebTgl" class="form-input" value="<?= date('Y-m-d') ?>"></div>
            </div>
            <div class="form-group"><label>Kategori</label><select name="kategori_item" id="ebKat" class="form-input"><option value="">Pilih...</option><option value="protein">🍗 Protein</option><option value="sayur">🥬 Sayur</option><option value="bumbu">🧂 Bumbu</option><option value="bahan_pokok">🍚 Bahan Pokok</option><option value="minyak">🫗 Minyak</option><option value="lainnya">📦 Lainnya</option></select></div>
            <div class="d-flex gap-1 mt-2"><button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('editBelanja')">Batal</button><button type="submit" class="btn-mp btn-brand" style="flex:2;justify-content:center">💾 Update</button></div>
        </form>
    </div>
</div></div>

<!-- Edit Pengeluaran Lain -->
<div class="mo" id="editLain"><div class="mo-box">
    <div class="mo-head"><h4>✏️ Edit Pengeluaran Lain</h4><button class="mo-x" onclick="closeModal('editLain')">&times;</button></div>
    <div class="mo-body">
        <form action="<?= site_url('pengeluaran-lain/update') ?>" method="POST">
            <input type="hidden" name="id_pengeluaran_lain" id="elId"><input type="hidden" name="bulan" value="<?= $bulan ?>"><input type="hidden" name="tahun" value="<?= $tahun ?>">
            <div class="form-group"><label>Nama *</label><input type="text" name="nama" id="elNama" class="form-input" required></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group"><label>Jumlah (Rp) *</label><input type="number" name="jumlah" id="elJumlah" class="form-input" required min="500" step="500"></div>
                <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" id="elTgl" class="form-input"></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group"><label>Kategori</label><select name="kategori" id="elKat" class="form-input"><option value="tagihan">💡 Tagihan</option><option value="asuransi">🛡️ Asuransi</option><option value="peralatan">🔧 Peralatan</option><option value="transportasi">🚗 Transportasi</option><option value="pendidikan">📚 Pendidikan</option><option value="kesehatan">🏥 Kesehatan</option><option value="hiburan">🎬 Hiburan</option><option value="lainnya">📦 Lainnya</option></select></div>
                <div class="form-group"><label>Catatan</label><input type="text" name="catatan" id="elCat" class="form-input"></div>
            </div>
            <div class="form-group"><label style="display:flex;align-items:center;gap:6px;cursor:pointer"><input type="checkbox" name="is_rutin" id="elRutin" value="1" style="accent-color:var(--sky);width:16px;height:16px"><span>🔁 Rutin</span></label></div>
            <div class="d-flex gap-1 mt-2"><button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeModal('editLain')">Batal</button><button type="submit" class="btn-mp btn-brand" style="flex:2;justify-content:center;background:var(--brand-dark);border-color:var(--brand-dark)">💾 Update</button></div>
        </form>
    </div>
</div></div>

<!-- Edit Budget Bulanan -->
<div class="mo" id="editBudgetBln"><div class="mo-box">
    <div class="mo-head"><h4>✏️ Edit Budget Bulanan</h4><button class="mo-x" onclick="closeModal('editBudgetBln')">&times;</button></div>
    <div class="mo-body">
        <div class="form-group" id="fgBelanja"><label>🛒 Budget Belanja (Rp)</label><input type="number" id="bbBelanja" class="form-input" value="<?= (int)$bb->budget_belanja ?>" min="0" step="50000"></div>
        <div class="form-group" id="fgLainnya"><label>💸 Budget Pengeluaran Lain (Rp)</label><input type="number" id="bbLainnya" class="form-input" value="<?= (int)$bb->budget_lainnya ?>" min="0" step="50000"></div>
        <button onclick="saveBudgetBln()" class="btn-mp btn-brand w-full" style="justify-content:center">💾 Simpan</button>
    </div>
</div></div>

<script>
function openModal(id){document.getElementById(id).classList.add('open')}
function closeModal(id){document.getElementById(id).classList.remove('open')}
document.querySelectorAll('.mo').forEach(function(m){m.addEventListener('click',function(e){if(e.target===this)this.classList.remove('open')})});
document.addEventListener('keydown',function(e){if(e.key==='Escape')document.querySelectorAll('.mo.open').forEach(function(m){m.classList.remove('open')})});

function hapusItem(id){
    if(!confirm('Hapus item ini?'))return;
    var r=document.getElementById('bl-'+id);if(r){r.style.transition='all .3s';r.style.opacity='0'}
    $.post('<?=site_url("belanja/hapus")?>',{id_belanja:id},function(){setTimeout(function(){location.reload()},350)},'json');
}
function hapusLain(id){
    if(!confirm('Hapus pengeluaran ini?'))return;
    var r=document.getElementById('pl-'+id);if(r){r.style.transition='all .3s';r.style.opacity='0'}
    $.post('<?=site_url("pengeluaran-lain/hapus")?>',{id:id},function(){setTimeout(function(){location.reload()},350)},'json');
}
function editBelanja(id){
    var r=document.getElementById('bl-'+id);if(!r)return;
    document.getElementById('ebId').value=id;
    document.getElementById('ebNama').value=r.dataset.nama;
    document.getElementById('ebJumlah').value=r.dataset.jumlah;
    document.getElementById('ebSatuan').value=r.dataset.satuan;
    document.getElementById('ebHarga').value=r.dataset.harga;
    document.getElementById('ebKat').value=r.dataset.kat||'';
    document.getElementById('ebTgl').value=r.dataset.tgl||'<?= date("Y-m-d") ?>';
    openModal('editBelanja');
}
function editLain(id){
    var r=document.getElementById('pl-'+id);if(!r)return;
    document.getElementById('elId').value=id;
    document.getElementById('elNama').value=r.dataset.nama;
    document.getElementById('elJumlah').value=r.dataset.jumlah;
    document.getElementById('elKat').value=r.dataset.kategori||'lainnya';
    document.getElementById('elTgl').value=r.dataset.tanggal;
    document.getElementById('elCat').value=r.dataset.catatan||'';
    document.getElementById('elRutin').checked=(r.dataset.rutin=='1');
    openModal('editLain');
}
var budgetEditType='';
function editBudgetBln(type){
    budgetEditType=type;
    document.getElementById('fgBelanja').style.display=(type=='belanja'||type=='both')?'block':'none';
    document.getElementById('fgLainnya').style.display=(type=='lainnya'||type=='both')?'block':'none';
    openModal('editBudgetBln');
}
function saveBudgetBln(){
    var data={bulan:<?=$bulan?>,tahun:<?=$tahun?>};
    if(budgetEditType=='belanja'||budgetEditType=='both') data.budget_belanja=document.getElementById('bbBelanja').value;
    if(budgetEditType=='lainnya'||budgetEditType=='both') data.budget_lainnya=document.getElementById('bbLainnya').value;
    $.post('<?=site_url("belanja/update-budget")?>',data,function(){closeModal('editBudgetBln');location.reload()},'json');
}
var suggestTimer;
document.getElementById('addNama').addEventListener('input',function(){
    var q=this.value.trim();clearTimeout(suggestTimer);if(q.length<2)return;
    suggestTimer=setTimeout(function(){
        $.get('<?=site_url("master-harga/search")?>?q='+encodeURIComponent(q),function(res){
            var r=(typeof res==='string')?JSON.parse(res):res;
            var dl=document.getElementById('bahanSuggest');dl.innerHTML='';
            if(r.data&&r.data.length){r.data.forEach(function(h){
                var opt=document.createElement('option');opt.value=h.nama_bahan;
                opt.setAttribute('data-harga',h.harga_satuan);opt.setAttribute('data-satuan',h.satuan);opt.setAttribute('data-kat',h.kategori_bahan||'');
                dl.appendChild(opt);
            })}
        });
    },300);
});
document.getElementById('addNama').addEventListener('change',function(){
    var val=this.value,opts=document.getElementById('bahanSuggest').options;
    for(var i=0;i<opts.length;i++){if(opts[i].value===val){
        var h=opts[i].getAttribute('data-harga'),s=opts[i].getAttribute('data-satuan'),k=opts[i].getAttribute('data-kat');
        if(h)document.getElementById('addHarga').value=h;if(s)document.getElementById('addSatuan').value=s;if(k)document.getElementById('addKat').value=k;break;
    }}
});

// Fitur 5: Template
function saveCurrentAsTemplate(){
    var nama=prompt('Nama template:','Belanja <?= $nama_bulan[$bulan] ?>');
    if(!nama)return;
    var items=[];
    document.querySelectorAll('[id^="bl-"]').forEach(function(r){
        items.push({nama_item:r.dataset.nama,jumlah:r.dataset.jumlah||1,satuan:r.dataset.satuan||'buah',estimasi_harga:r.dataset.harga||0,kategori_item:r.dataset.kat||''});
    });
    if(!items.length){alert('Tidak ada item untuk disimpan');return;}
    $.post('<?=site_url("template/save")?>',{nama_template:nama,items:JSON.stringify(items)},function(res){
        var r=(typeof res==='string')?JSON.parse(res):res;
        if(r.status==0){alert('Template berhasil disimpan!');location.reload();}else{alert(r.msg||'Gagal');}
    });
}
function hapusTemplate(id){
    if(!confirm('Hapus template ini?'))return;
    $.post('<?=site_url("template/delete")?>',{id_template:id},function(){location.reload()},'json');
}
</script>

<!-- PEMASUKAN BULANAN -->
<style>
    .inc-card { background:linear-gradient(135deg, #16a34a, #15803d); color:#fff; border-radius:var(--radius); padding:20px; margin-bottom:16px; box-shadow:0 8px 24px rgba(22,163,74,.15); }
    .inc-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; margin-top:12px; }
    .inc-box { background:rgba(255,255,255,.15); border-radius:10px; padding:8px 12px; }
    .inc-box .ib-label { font-size:.6rem; opacity:.7; font-weight:600; }
    .inc-box .ib-val { font-size:.95rem; font-weight:800; }
    .inc-box.ib-minus .ib-val { color:#fca5a5; }
    .inc-box.ib-saldo .ib-val { color:#fef08a; }

    .pe-row { display:flex; align-items:center; gap:10px; padding:10px 16px; border-bottom:1px solid var(--stone-100); transition:background .15s; }
    .pe-row:last-child { border-bottom:none; }
    .pe-row:hover { background:var(--stone-50); }
    .pe-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .pe-info { flex:1; min-width:0; }
    .pe-name { font-size:.85rem; font-weight:700; color:var(--stone-800); }
    .pe-meta { font-size:.65rem; color:var(--stone-400); font-weight:600; }
    .pe-amount { font-size:.9rem; font-weight:800; color:var(--green); white-space:nowrap; }
    .pe-del { width:24px; height:24px; border-radius:6px; border:none; background:transparent; color:var(--stone-300); cursor:pointer; font-size:.7rem; opacity:0; transition:all .15s; }
    .pe-row:hover .pe-del { opacity:1; }
    .pe-del:hover { background:#fef2f2; color:var(--red); }

    .mo { position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:500; display:none; backdrop-filter:blur(4px); }
    .mo.open { display:flex; align-items:center; justify-content:center; padding:16px; }
    .mo-box { background:#fff; border-radius:var(--radius); box-shadow:0 24px 80px rgba(0,0,0,.15); width:100%; max-width:420px; animation:fadeUp .3s var(--ease); overflow:hidden; }
    .mo-head { padding:14px 18px; border-bottom:1px solid var(--stone-100); display:flex; justify-content:space-between; align-items:center; }
    .mo-head h4 { font-size:.92rem; font-weight:700; }
    .mo-x { background:var(--stone-50); border:none; width:30px; height:30px; border-radius:8px; font-size:1.1rem; cursor:pointer; color:var(--stone-400); }
    .mo-x:hover { background:var(--stone-200); }
    .mo-body { padding:16px 18px; }
</style>

<?php
$nama_bulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$s = $saldo;
$sumber_icons = ['Gaji'=>'💰','Bonus'=>'🎁','Freelance'=>'💻','Transfer'=>'🏦','Lainnya'=>'📦'];
?>

<!-- Header -->
<div class="d-flex justify-between items-center" style="margin-bottom:14px;">
    <div>
        <h1 style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; letter-spacing:-.03em;">💰 Pemasukan</h1>
        <p class="fs-sm text-muted"><?= $nama_bulan[$bulan] ?> <?= $tahun ?></p>
    </div>
    <button class="btn-mp btn-brand btn-sm" onclick="openAdd()">➕ Tambah</button>
</div>

<!-- Month nav -->
<div style="display:flex; gap:4px; margin-bottom:14px; overflow-x:auto; padding-bottom:4px;">
    <?php for ($i = 0; $i < 6; $i++):
        $dt = strtotime("-{$i} months"); $m=(int)date('m',$dt); $y=(int)date('Y',$dt);
        $active = ($m==$bulan && $y==$tahun);
    ?>
        <a href="<?= site_url('pemasukan?bulan='.$m.'&tahun='.$y) ?>" style="font-family:var(--font); font-size:.72rem; font-weight:600; padding:5px 12px; border-radius:16px; border:1.5px solid <?= $active ? 'var(--brand)' : 'var(--stone-200)' ?>; background:<?= $active ? 'var(--brand)' : '#fff' ?>; color:<?= $active ? '#fff' : 'var(--stone-500)' ?>; text-decoration:none; white-space:nowrap;"><?= substr($nama_bulan[$m],0,3) ?> <?= substr($y,2) ?></a>
    <?php endfor; ?>
</div>

<!-- Saldo Card -->
<div class="inc-card anim-up">
    <div class="d-flex justify-between items-center">
        <div>
            <p style="font-size:.7rem; opacity:.7; font-weight:600;">Total Pemasukan</p>
            <p style="font-size:1.6rem; font-weight:800;">Rp<?= number_format($total, 0, ',', '.') ?></p>
        </div>
        <div style="font-size:2.5rem; opacity:.3;">💰</div>
    </div>
    <div class="inc-grid" style="grid-template-columns:repeat(4, 1fr);">
        <div class="inc-box">
            <p class="ib-label">🍽️ Dapur</p>
            <p class="ib-val">Rp<?= number_format($s['total_dapur'], 0, ',', '.') ?></p>
        </div>
        <div class="inc-box">
            <p class="ib-label">🛒 Belanja</p>
            <p class="ib-val">Rp<?= number_format($s['total_belanja'], 0, ',', '.') ?></p>
        </div>
        <div class="inc-box inc-minus">
            <p class="ib-label">💸 Lain-lain</p>
            <p class="ib-val">Rp<?= number_format($s['total_lain'] ?? 0, 0, ',', '.') ?></p>
        </div>
        <div class="inc-box ib-saldo">
            <p class="ib-label"><?= $s['saldo'] >= 0 ? '✅ Sisa Saldo' : '⚠️ Minus' ?></p>
            <p class="ib-val">Rp<?= number_format(abs($s['saldo']), 0, ',', '.') ?></p>
        </div>
    </div>
</div>

<!-- Pemasukan per Sumber -->
<?php if (!empty($s['per_sumber'])): ?>
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header"><h3 style="font-size:.88rem;">📊 Per Sumber</h3></div>
    <div class="mp-card-body">
        <?php foreach ($s['per_sumber'] as $ps):
            $pct = $total > 0 ? round($ps->total / $total * 100) : 0;
        ?>
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                <div style="width:32px; height:32px; border-radius:8px; background:var(--green-soft); display:flex; align-items:center; justify-content:center; font-size:.9rem;">
                    <?= $sumber_icons[$ps->sumber] ?? '💰' ?>
                </div>
                <div style="flex:1;">
                    <div style="font-size:.82rem; font-weight:700; color:var(--stone-700);"><?= htmlspecialchars($ps->sumber) ?> <span style="font-size:.6rem; color:var(--stone-400);"><?= $pct ?>%</span></div>
                    <div style="height:6px; background:var(--stone-100); border-radius:3px; overflow:hidden; margin-top:3px;">
                        <div style="width:<?= $pct ?>%; height:100%; background:var(--green); border-radius:3px;"></div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <span style="font-size:.82rem; font-weight:800; color:var(--stone-700);">Rp<?= number_format($ps->total, 0, ',', '.') ?></span>
                    <br><span style="font-size:.6rem; color:var(--stone-400); font-weight:600;"><?= $ps->kali ?>x</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- List Pemasukan -->
<div class="mp-card anim-up mb-2">
    <div class="mp-card-header">
        <h3 style="font-size:.88rem;">📋 Daftar Pemasukan</h3>
        <span class="badge badge-green"><?= count($list) ?></span>
    </div>
    <?php if (empty($list)): ?>
        <div class="mp-card-body text-center" style="padding:2rem;">
            <p style="font-size:2.5rem; margin-bottom:6px;">💰</p>
            <p style="font-weight:700; color:var(--stone-600);">Belum ada pemasukan</p>
            <p class="fs-sm text-muted">Klik "Tambah" untuk mencatat pemasukan bulan ini.</p>
        </div>
    <?php else: ?>
        <div style="padding:0;">
            <?php foreach ($list as $p):
                $ic = $sumber_icons[$p->sumber] ?? '💰';
            ?>
                <div class="pe-row" id="pe-<?= $p->id_pemasukan ?>">
                    <div class="pe-icon" style="background:var(--green-soft);"><?= $ic ?></div>
                    <div class="pe-info">
                        <p class="pe-name"><?= htmlspecialchars($p->sumber) ?></p>
                        <p class="pe-meta"><?= date('d M Y', strtotime($p->tanggal ?? $p->created_at)) ?><?= $p->catatan ? ' · ' . htmlspecialchars($p->catatan) : '' ?></p>
                    </div>
                    <span class="pe-amount">+Rp<?= number_format($p->jumlah, 0, ',', '.') ?></span>
                    <button class="pe-del" onclick="hapusPemasukan(<?= $p->id_pemasukan ?>)" title="Hapus">🗑</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Quick links -->
<div style="display:flex; gap:6px; justify-content:center; flex-wrap:wrap;">
    <a href="<?= site_url('laporan?bulan='.$bulan.'&tahun='.$tahun.'&tab=saldo') ?>" class="btn-mp btn-brand btn-sm">📊 Laporan Saldo</a>
    <a href="<?= site_url('pengeluaran') ?>" class="btn-mp btn-outline btn-sm">🍽️ Pengeluaran</a>
    <a href="<?= site_url('belanja') ?>" class="btn-mp btn-outline btn-sm">🛒 Belanja</a>
</div>

<!-- Modal Tambah -->
<div class="mo" id="addModal">
    <div class="mo-box">
        <div class="mo-head"><h4>➕ Tambah Pemasukan</h4><button class="mo-x" onclick="closeAdd()">&times;</button></div>
        <div class="mo-body">
            <form action="<?= site_url('pemasukan/simpan') ?>" method="POST">
                <input type="hidden" name="bulan" value="<?= $bulan ?>">
                <input type="hidden" name="tahun" value="<?= $tahun ?>">
                <div class="form-group">
                    <label>Sumber Pemasukan *</label>
                    <input type="text" name="sumber" class="form-input" required placeholder="cth: Gaji, Bonus, Freelance" list="sumberList" id="addSumber">
                    <datalist id="sumberList">
                        <option value="Gaji"><option value="Bonus"><option value="Freelance"><option value="Transfer"><option value="Lainnya">
                    </datalist>
                </div>
                <div class="form-group">
                    <label>Jumlah (Rp) *</label>
                    <input type="number" name="jumlah" class="form-input" required min="1000" step="1000" placeholder="5000000">
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-input" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <input type="text" name="catatan" class="form-input" placeholder="(opsional)">
                    </div>
                </div>
                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeAdd()">Batal</button>
                    <button type="submit" class="btn-mp btn-brand" style="flex:2; justify-content:center;">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAdd() { document.getElementById('addModal').classList.add('open'); setTimeout(function(){ document.getElementById('addSumber').focus(); }, 200); }
function closeAdd() { document.getElementById('addModal').classList.remove('open'); }
document.getElementById('addModal').addEventListener('click', function(e) { if(e.target===this) closeAdd(); });
document.addEventListener('keydown', function(e) { if(e.key==='Escape') closeAdd(); });

function hapusPemasukan(id) {
    if (!confirm('Hapus pemasukan ini?')) return;
    var row = document.getElementById('pe-' + id);
    if (row) { row.style.transition = 'all .3s'; row.style.opacity = '0'; }
    $.post('<?= site_url("pemasukan/hapus") ?>', { id_pemasukan: id, bulan: <?= $bulan ?>, tahun: <?= $tahun ?> }, function() {
        setTimeout(function() { if(row) row.remove(); location.reload(); }, 300);
    }, 'json');
}
</script>

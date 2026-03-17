<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Keuangan — <?= $nama_bulan[$bulan] ?> <?= $tahun ?></title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<style>
    @page { size: A4; margin: 20mm 18mm 20mm 18mm; }
    @media print {
        body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        .no-print { display: none !important; }
    }

    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: 'Nunito', sans-serif; color: #332a25; font-size: 11px; background: #fff; line-height: 1.5; }

    /* ── Print Button ── */
    .print-bar {
        position: fixed; top: 0; left: 0; right: 0; z-index: 100;
        background: linear-gradient(135deg, #f078a0, #e8608c);
        padding: 12px 24px; display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 4px 20px rgba(232,96,140,.2);
    }
    .print-bar span { font-size: 14px; font-weight: 800; color: #fff; }
    .print-bar button {
        background: #fff; color: #e8608c; border: none; padding: 8px 24px;
        border-radius: 8px; font-size: 13px; font-weight: 800; cursor: pointer;
        font-family: 'Nunito', sans-serif; transition: all .2s;
    }
    .print-bar button:hover { background: #fff5f7; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.1); }
    .page-wrap { padding-top: 60px; max-width: 800px; margin: 0 auto; padding-left: 20px; padding-right: 20px; }
    @media print { .page-wrap { padding-top: 0; max-width: none; padding-left:0; padding-right:0; } }

    /* ── Header ── */
    .report-header {
        background: linear-gradient(135deg, #f9e0e8 0%, #fce8ed 50%, #fff0f4 100%);
        border-radius: 16px; padding: 28px 32px; margin-bottom: 24px;
        border: 1.5px solid #ffd1db; position: relative; overflow: hidden;
    }
    .report-header::before {
        content: ''; position: absolute; top: -30px; right: -30px;
        width: 120px; height: 120px; border-radius: 50%;
        background: rgba(232,96,140,.08);
    }
    .report-header::after {
        content: ''; position: absolute; bottom: -20px; left: 40%;
        width: 80px; height: 80px; border-radius: 50%;
        background: rgba(232,96,140,.05);
    }
    .rh-logo { font-size: 22px; font-weight: 900; color: #d14a76; margin-bottom: 2px; }
    .rh-sub { font-size: 12px; color: #8a7e77; font-weight: 600; }
    .rh-period { font-size: 18px; font-weight: 900; color: #332a25; margin-top: 10px; }
    .rh-date { font-size: 10px; color: #b5aaa2; font-weight: 600; margin-top: 4px; }

    /* ── Saldo Card ── */
    .saldo-card {
        border-radius: 14px; padding: 22px 28px; margin-bottom: 20px; color: #fff;
    }
    .saldo-pos { background: linear-gradient(135deg, #34d399, #10b981); }
    .saldo-neg { background: linear-gradient(135deg, #f87171, #ef4444); }
    .saldo-label { font-size: 10px; font-weight: 700; opacity: .8; text-transform: uppercase; letter-spacing: .5px; }
    .saldo-amount { font-size: 26px; font-weight: 900; margin: 4px 0 12px; }
    .saldo-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
    .saldo-box { background: rgba(255,255,255,.18); border-radius: 8px; padding: 8px 10px; }
    .saldo-box .sb-l { font-size: 8px; font-weight: 700; opacity: .7; }
    .saldo-box .sb-v { font-size: 12px; font-weight: 800; }

    /* ── Bar Chart ── */
    .bar-section { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 20px; }
    .bar-item { background: #fff5f7; border: 1px solid #ffe8ed; border-radius: 10px; padding: 12px; text-align: center; }
    .bar-item .bi-val { font-size: 15px; font-weight: 900; color: #e8608c; }
    .bar-item .bi-label { font-size: 9px; font-weight: 700; color: #8a7e77; margin-top: 2px; }
    .bar-item.green .bi-val { color: #10b981; }
    .bar-item.green { background: #edfcf2; border-color: #d1fae5; }
    .bar-item.red .bi-val { color: #ef4444; }
    .bar-item.red { background: #fff0f2; border-color: #fecaca; }

    /* ── Section ── */
    .section { margin-bottom: 22px; }
    .section-title {
        font-size: 13px; font-weight: 900; color: #d14a76;
        padding: 8px 14px; border-radius: 8px;
        background: linear-gradient(135deg, #fff0f4, #fce8ed);
        border-left: 4px solid #e8608c; margin-bottom: 10px;
        display: flex; align-items: center; gap: 6px;
    }

    /* ── Table ── */
    table { width: 100%; border-collapse: collapse; font-size: 10px; }
    table thead th {
        background: linear-gradient(135deg, #e8608c, #d14a76);
        color: #fff; font-weight: 800; font-size: 9px;
        padding: 8px 10px; text-align: left; text-transform: uppercase;
        letter-spacing: .5px;
    }
    table thead th:first-child { border-radius: 8px 0 0 0; }
    table thead th:last-child { border-radius: 0 8px 0 0; }
    table tbody td {
        padding: 7px 10px; border-bottom: 1px solid #ffe8ed;
        font-weight: 600; color: #4a3f38;
    }
    table tbody tr:nth-child(even) td { background: #fffafb; }
    table tbody tr:hover td { background: #fff0f4; }
    .td-right { text-align: right; }
    .td-bold { font-weight: 800; color: #332a25; }
    .td-pink { color: #e8608c; font-weight: 800; }
    .td-green { color: #10b981; font-weight: 800; }

    /* ── Total Row ── */
    table tfoot td {
        padding: 10px; font-weight: 900; font-size: 11px;
        border-top: 2px solid #e8608c; color: #d14a76;
    }

    /* ── Footer ── */
    .report-footer {
        margin-top: 24px; padding: 16px 0; border-top: 1.5px solid #ffe8ed;
        display: flex; justify-content: space-between; align-items: center;
    }
    .rf-left { font-size: 10px; color: #b5aaa2; font-weight: 600; }
    .rf-right { font-size: 9px; color: #d6d3d2; font-weight: 600; }

    /* ── Badge ── */
    .badge-kat {
        font-size: 8px; font-weight: 700; padding: 2px 6px;
        border-radius: 4px; background: #fff0f4; color: #e8608c;
    }
    .badge-rutin { background: #eef7ff; color: #3ba4e8; }
    .empty-msg { text-align: center; padding: 20px; color: #b5aaa2; font-weight: 600; font-style: italic; }
</style>
</head>
<body>

<!-- Print Bar -->
<div class="print-bar no-print">
    <span>🏠 Our Home — Laporan <?= $nama_bulan[$bulan] ?> <?= $tahun ?></span>
    <div>
        <button onclick="window.print()" style="margin-right:8px">🖨️ Cetak / Save PDF</button>
        <button onclick="window.close()" style="background:transparent;color:#fff;border:1px solid rgba(255,255,255,.4)">← Kembali</button>
    </div>
</div>

<div class="page-wrap">

<!-- Header -->
<div class="report-header">
    <div style="position:relative;z-index:1">
        <p class="rh-logo">🏠 Our Home</p>
        <p class="rh-sub">Laporan Keuangan Keluarga</p>
        <p class="rh-period">📊 <?= $nama_bulan[$bulan] ?> <?= $tahun ?></p>
        <p class="rh-date">Dicetak oleh <?= htmlspecialchars($user_name) ?> · <?= date('d M Y, H:i') ?> WIB</p>
    </div>
</div>

<!-- Saldo -->
<?php $s = $saldo; ?>
<div class="saldo-card <?= $s['saldo'] >= 0 ? 'saldo-pos' : 'saldo-neg' ?>">
    <p class="saldo-label"><?= $s['saldo'] >= 0 ? '✅ Saldo Bulan Ini' : '⚠️ Defisit Bulan Ini' ?></p>
    <p class="saldo-amount">Rp<?= number_format(abs($s['saldo']), 0, ',', '.') ?></p>
    <div class="saldo-grid">
        <div class="saldo-box"><p class="sb-l">💰 Pemasukan</p><p class="sb-v">Rp<?= number_format($s['total_pemasukan'], 0, ',', '.') ?></p></div>
        <div class="saldo-box"><p class="sb-l">🍽️ Dapur</p><p class="sb-v">Rp<?= number_format($s['total_dapur'], 0, ',', '.') ?></p></div>
        <div class="saldo-box"><p class="sb-l">🛒 Belanja</p><p class="sb-v">Rp<?= number_format($s['total_belanja'], 0, ',', '.') ?></p></div>
        <div class="saldo-box"><p class="sb-l">💸 Lain</p><p class="sb-v">Rp<?= number_format($s['total_lain'], 0, ',', '.') ?></p></div>
    </div>
</div>

<!-- Summary Boxes -->
<div class="bar-section">
    <div class="bar-item green"><p class="bi-val">Rp<?= number_format($s['total_pemasukan'], 0, ',', '.') ?></p><p class="bi-label">Total Pemasukan</p></div>
    <div class="bar-item"><p class="bi-val">Rp<?= number_format($s['total_keluar'], 0, ',', '.') ?></p><p class="bi-label">Total Pengeluaran</p></div>
    <div class="bar-item <?= $s['saldo'] >= 0 ? 'green' : 'red' ?>"><p class="bi-val">Rp<?= number_format(abs($s['saldo']), 0, ',', '.') ?></p><p class="bi-label"><?= $s['saldo'] >= 0 ? 'Sisa Saldo' : 'Defisit' ?></p></div>
    <div class="bar-item"><p class="bi-val"><?= count($dapur_list) + count($belanja) + count($pengeluaran_lain) ?></p><p class="bi-label">Total Transaksi</p></div>
</div>

<!-- ═══ PENGELUARAN DAPUR ═══ -->
<div class="section">
    <div class="section-title">🍽️ Pengeluaran Dapur</div>
    <?php if (empty($dapur_list)): ?>
        <p class="empty-msg">Tidak ada data pengeluaran dapur.</p>
    <?php else: ?>
    <?php $total_dapur = 0; ?>
    <table>
        <thead><tr><th>No</th><th>Tanggal</th><th>Nama Barang</th><th>Kategori</th><th>Catatan</th><th style="text-align:right">Harga</th></tr></thead>
        <tbody>
            <?php $no = 1; foreach ($dapur_list as $r): $total_dapur += (float)$r->harga; ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d M Y', strtotime($r->tanggal)) ?></td>
                <td class="td-bold"><?= htmlspecialchars($r->nama_barang) ?></td>
                <td><span class="badge-kat"><?= ucfirst($r->kategori ?? 'lainnya') ?></span></td>
                <td style="color:#8a7e77"><?= htmlspecialchars($r->catatan ?? '-') ?></td>
                <td class="td-right td-pink">Rp<?= number_format($r->harga, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot><tr><td colspan="5">Total Pengeluaran Dapur</td><td class="td-right">Rp<?= number_format($total_dapur, 0, ',', '.') ?></td></tr></tfoot>
    </table>
    <?php endif; ?>
</div>

<!-- ═══ BELANJA BULANAN ═══ -->
<div class="section">
    <div class="section-title">🛒 Belanja Bulanan</div>
    <?php if (empty($belanja)): ?>
        <p class="empty-msg">Tidak ada data belanja.</p>
    <?php else: ?>
    <?php $total_bel = 0; ?>
    <table>
        <thead><tr><th>No</th><th>Tanggal</th><th>Nama Item</th><th>Jumlah</th><th>Kategori</th><th style="text-align:right">Harga</th></tr></thead>
        <tbody>
            <?php $no = 1; foreach ($belanja as $b): $total_bel += (float)$b->estimasi_harga; ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d M Y', strtotime($b->created_at)) ?></td>
                <td class="td-bold"><?= htmlspecialchars($b->nama_item) ?></td>
                <td><?= $b->jumlah ?> <?= htmlspecialchars($b->satuan) ?></td>
                <td><span class="badge-kat"><?= ucfirst($b->kategori_item ?? 'lainnya') ?></span></td>
                <td class="td-right td-pink">Rp<?= number_format($b->estimasi_harga, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot><tr><td colspan="5">Total Belanja</td><td class="td-right">Rp<?= number_format($total_bel, 0, ',', '.') ?></td></tr></tfoot>
    </table>
    <?php endif; ?>
</div>

<!-- ═══ PENGELUARAN LAIN ═══ -->
<div class="section">
    <div class="section-title">💸 Pengeluaran Lain</div>
    <?php if (empty($pengeluaran_lain)): ?>
        <p class="empty-msg">Tidak ada data pengeluaran lain.</p>
    <?php else: ?>
    <?php $total_lain = 0; ?>
    <table>
        <thead><tr><th>No</th><th>Tanggal</th><th>Nama</th><th>Kategori</th><th>Catatan</th><th style="text-align:right">Jumlah</th></tr></thead>
        <tbody>
            <?php $no = 1; foreach ($pengeluaran_lain as $p): $total_lain += (float)$p->jumlah; ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d M Y', strtotime($p->tanggal)) ?></td>
                <td class="td-bold"><?= htmlspecialchars($p->nama) ?></td>
                <td>
                    <span class="badge-kat"><?= ucfirst($p->kategori ?? 'lainnya') ?></span>
                    <?php if ($p->is_rutin): ?><span class="badge-kat badge-rutin">🔁 Rutin</span><?php endif; ?>
                </td>
                <td style="color:#8a7e77"><?= htmlspecialchars($p->catatan ?? '-') ?></td>
                <td class="td-right td-pink">Rp<?= number_format($p->jumlah, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot><tr><td colspan="5">Total Pengeluaran Lain</td><td class="td-right">Rp<?= number_format($total_lain, 0, ',', '.') ?></td></tr></tfoot>
    </table>
    <?php endif; ?>
</div>

<!-- Footer -->
<div class="report-footer">
    <div class="rf-left">🏠 Our Home — Laporan Keuangan <?= $nama_bulan[$bulan] ?> <?= $tahun ?></div>
    <div class="rf-right">Dicetak: <?= date('d/m/Y H:i') ?> · Halaman 1</div>
</div>

</div><!-- end page-wrap -->

<script>
// Auto open print dialog after page loads
window.addEventListener('load', function() {
    setTimeout(function() { window.print(); }, 500);
});
</script>
</body>
</html>

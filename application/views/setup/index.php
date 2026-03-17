<!-- SETUP -->
<div class="page-header text-center" style="padding-top:1.5rem;">
    <div style="font-size:3rem; margin-bottom:8px;">🍽️</div>
    <h1>Setup OurHome</h1>
    <p>Atur kebutuhan makan keluarga kamu</p>
    <a href="<?= site_url('dashboard') ?>" class="btn-mp btn-outline btn-sm mt-1">← Kembali ke Dashboard</a>
</div>

<div class="mp-card anim-up" style="max-width:480px; margin:0 auto;">
    <div class="mp-card-body" style="padding:1.5rem">
        <form action="<?= site_url('setup/save') ?>" method="POST">
            <div class="form-group">
                <label>👨‍👩‍👧 Jumlah Orang Makan</label>
                <input type="number" name="jumlah_orang" class="form-input" value="<?= $settings->jumlah_orang ?? 2 ?>" min="1" max="20" required>
            </div>

            <div class="form-group">
                <label>🕐 Frekuensi Makan per Hari</label>
                <div class="grid-2">
                    <label style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:var(--stone-50); border-radius:var(--radius-xs); cursor:pointer; border:1.5px solid var(--stone-200); transition:border-color .2s;">
                        <input type="radio" name="frekuensi_makan" value="2" <?= (($settings->frekuensi_makan ?? 3) == 2) ? 'checked' : '' ?> style="accent-color:var(--brand);">
                        <span style="font-size:.88rem; font-weight:600;">2x Makan</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:var(--stone-50); border-radius:var(--radius-xs); cursor:pointer; border:1.5px solid var(--stone-200); transition:border-color .2s;">
                        <input type="radio" name="frekuensi_makan" value="3" <?= (($settings->frekuensi_makan ?? 3) == 3) ? 'checked' : '' ?> style="accent-color:var(--brand);">
                        <span style="font-size:.88rem; font-weight:600;">3x Makan</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>💰 Budget Mingguan (Rp)</label>
                <input type="number" name="budget_mingguan" class="form-input" value="<?= $settings->budget_mingguan ?? 300000 ?>" min="50000" step="10000" required>
            </div>

            <div class="form-group">
                <label>🥗 Preferensi Makanan</label>
                <?php
                $pref = $settings ? json_decode($settings->preferensi, true) : [];
                $options = [
                    'ayam'       => '🍗 Ayam',
                    'ikan'       => '🐟 Ikan',
                    'daging'     => '🥩 Daging',
                    'telur'      => '🥚 Telur',
                    'tahu_tempe' => '🫘 Tahu/Tempe',
                    'sayur'      => '🥬 Sayur',
                    'vegetarian' => '🌿 Vegetarian',
                ];
                ?>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    <?php foreach ($options as $val => $label) : ?>
                        <label style="display:flex; align-items:center; gap:5px; padding:7px 12px; background:var(--stone-50); border-radius:20px; cursor:pointer; border:1.5px solid var(--stone-200); font-size:.82rem; font-weight:600; transition:all .2s;">
                            <input type="checkbox" name="preferensi[]" value="<?= $val ?>" <?= in_array($val, $pref ?: []) ? 'checked' : '' ?> style="accent-color:var(--brand); width:14px; height:14px;">
                            <?= $label ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn-mp btn-brand w-full mt-2" style="justify-content:center; padding:12px;">
                ✅ Simpan Pengaturan
            </button>
        </form>
    </div>
</div>
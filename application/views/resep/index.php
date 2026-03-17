<!-- DATABASE RESEP - With Photo Upload -->
<style>
    .search-bar { position:relative; margin-bottom:14px; }
    .search-bar input { width:100%; font-family:var(--font); font-size:.88rem; padding:10px 14px 10px 38px; border:1.5px solid var(--stone-200); border-radius:var(--radius-sm); background:#fff; }
    .search-bar input:focus { outline:none; border-color:var(--brand); box-shadow:0 0 0 3px rgba(232,93,38,.08); }
    .search-bar .si { position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:1rem; }
    .search-bar .sc { position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; font-size:1rem; color:var(--stone-300); cursor:pointer; display:none; }
    .search-bar .sc.show { display:block; }

    .kat-pills { display:flex; gap:6px; flex-wrap:nowrap; margin-bottom:16px; overflow-x:auto; padding-bottom:4px; }
    .kat-pill { font-family:var(--font); font-size:.78rem; font-weight:600; padding:6px 14px; border-radius:20px; border:1.5px solid var(--stone-200); background:#fff; color:var(--stone-600); cursor:pointer; transition:all .2s; white-space:nowrap; text-decoration:none; }
    .kat-pill:hover { border-color:var(--brand); color:var(--brand); }
    .kat-pill.active { background:var(--brand); color:#fff; border-color:var(--brand); }

    .stats-bar { display:flex; gap:8px; margin-bottom:14px; flex-wrap:wrap; }
    .stat-chip { font-size:.72rem; font-weight:600; padding:5px 12px; border-radius:8px; background:#fff; border:1px solid var(--stone-200); color:var(--stone-600); }
    .stat-chip strong { color:var(--stone-800); }

    .resep-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(170px, 1fr)); gap:12px; }
    @media(max-width:480px) { .resep-grid { grid-template-columns:repeat(2,1fr); gap:8px; } }

    .rc { background:#fff; border:1px solid var(--stone-200); border-radius:var(--radius); overflow:hidden; transition:all .3s; cursor:pointer; position:relative; }
    .rc:hover { box-shadow:0 8px 24px rgba(0,0,0,.08); transform:translateY(-3px); }
    .rc::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--stone-200); transition:background .3s; }
    .rc:hover::before { background:var(--brand); }

    /* Photo area */
    .rc-photo { width:100%; height:110px; background:var(--stone-50); display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
    .rc-photo img { width:100%; height:100%; object-fit:cover; }
    .rc-photo .rc-emoji { font-size:2.5rem; }
    .rc-photo .rc-no-photo { color:var(--stone-300); font-size:.7rem; font-weight:600; display:flex; flex-direction:column; align-items:center; gap:4px; }

    .rc-actions { position:absolute; top:6px; right:6px; display:flex; gap:2px; opacity:0; transition:opacity .2s; }
    .rc:hover .rc-actions { opacity:1; }
    .rc-act { width:26px; height:26px; border-radius:8px; border:none; cursor:pointer; font-size:.65rem; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,.9); color:var(--stone-500); backdrop-filter:blur(4px); }
    .rc-act:hover { background:var(--brand-light); color:var(--brand); }
    .rc-act.act-del:hover { background:#fef2f2; color:#dc2626; }
    .rc-act.act-fav { opacity:1 !important; font-size:.8rem; }

    .rc-body { padding:8px 12px 10px; }
    .rc-kat { font-size:.55rem; font-weight:700; color:var(--stone-400); text-transform:uppercase; letter-spacing:.04em; }
    .rc-name { font-size:.82rem; font-weight:700; color:var(--stone-800); margin:2px 0 4px; line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .rc-meta { display:flex; gap:4px; flex-wrap:wrap; }
    .rc-tag { font-size:.56rem; font-weight:700; padding:2px 6px; border-radius:4px; }
    .rc-tag-price { background:var(--brand-light); color:var(--brand-dark); }
    .rc-tag-time { background:var(--sky-soft); color:var(--sky); }
    .rc-tag-prep { background:var(--green); color:#fff; }
    .rc-tag-sys { background:var(--stone-100); color:var(--stone-400); }

    /* Modal */
    .mo { position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:500; display:none; backdrop-filter:blur(4px); }
    .mo.open { display:flex; align-items:center; justify-content:center; padding:16px; }
    .mo-box { background:#fff; border-radius:var(--radius); box-shadow:0 24px 80px rgba(0,0,0,.15); width:100%; max-width:520px; max-height:85vh; overflow-y:auto; animation:fadeUp .3s var(--ease); }
    .mo-head { padding:14px 18px; border-bottom:1px solid var(--stone-100); display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; background:#fff; z-index:1; border-radius:var(--radius) var(--radius) 0 0; }
    .mo-head h4 { font-size:.92rem; font-weight:700; }
    .mo-x { background:var(--stone-50); border:none; width:30px; height:30px; border-radius:8px; font-size:1.1rem; cursor:pointer; color:var(--stone-400); display:flex; align-items:center; justify-content:center; }
    .mo-x:hover { background:var(--stone-200); }
    .mo-body { padding:16px 18px; }

    .bahan-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 28px; gap:6px; align-items:center; margin-bottom:6px; }
    .bahan-remove { width:24px; height:24px; border-radius:6px; border:none; background:#fef2f2; color:#dc2626; cursor:pointer; font-size:.7rem; display:flex; align-items:center; justify-content:center; }
    .bahan-remove:hover { background:#dc2626; color:#fff; }

    /* Photo upload */
    .photo-upload { border:2px dashed var(--stone-200); border-radius:10px; padding:16px; text-align:center; cursor:pointer; transition:all .2s; position:relative; overflow:hidden; }
    .photo-upload:hover { border-color:var(--brand); background:var(--brand-light); }
    .photo-upload input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .photo-upload .pu-preview { max-height:120px; border-radius:8px; display:none; margin-bottom:6px; }
    .photo-upload .pu-text { font-size:.78rem; font-weight:600; color:var(--stone-400); }
    .photo-upload .pu-icon { font-size:1.5rem; margin-bottom:4px; }

    .detail-photo { width:100%; max-height:200px; object-fit:cover; border-radius:10px; margin-bottom:12px; }
    .detail-bahan-row { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid var(--stone-100); font-size:.84rem; }
    .detail-bahan-row:last-child { border-bottom:none; }

    .confirm-dialog { position:fixed; inset:0; z-index:600; background:rgba(0,0,0,.5); display:none; align-items:center; justify-content:center; padding:20px; }
    .confirm-dialog.active { display:flex; }
    .confirm-box { background:#fff; border-radius:var(--radius); box-shadow:0 24px 80px rgba(0,0,0,.15); padding:24px; max-width:360px; width:100%; text-align:center; animation:fadeUp .25s; }
</style>

<!-- Header -->
<div class="page-header d-flex justify-between items-center">
    <div>
        <h1>📖 Database Resep</h1>
        <p><?= count($resep_list) ?> resep tersedia</p>
    </div>
    <button class="btn-mp btn-brand btn-sm" onclick="openAddModal()">➕ Tambah</button>
</div>

<div class="search-bar">
    <span class="si">🔍</span>
    <input type="text" id="searchInput" placeholder="Cari resep... (cth: ayam, tempe, nasi goreng)">
    <button class="sc" id="searchClear" onclick="clearSearch()">&times;</button>
</div>

<div class="stats-bar">
    <div class="stat-chip">📊 Total: <strong><?= count($resep_list) ?></strong></div>
    <div class="stat-chip">❤️ Favorit: <strong><?= count($favorit_ids) ?></strong></div>
    <?php $mp = count(array_filter($resep_list, fn($r) => $r->is_meal_prep)); if ($mp): ?>
        <div class="stat-chip">📦 Meal Prep: <strong><?= $mp ?></strong></div>
    <?php endif; ?>
</div>

<div class="kat-pills">
    <a href="<?= site_url('resep') ?>" class="kat-pill <?= !$selected_kat ? 'active' : '' ?>">🍽️ Semua</a>
    <?php foreach ($kategori as $k): ?>
        <a href="<?= site_url('resep') ?>?kategori=<?= $k->id_kategori ?>" class="kat-pill <?= $selected_kat == $k->id_kategori ? 'active' : '' ?>">
            <?= $k->icon ?> <?= $k->nama_kategori ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Grid -->
<?php if (empty($resep_list)): ?>
    <div class="mp-card"><div class="mp-card-body text-center" style="padding:3rem"><p style="font-size:3rem">📖</p><p style="font-weight:700;color:var(--stone-600)">Belum ada resep</p></div></div>
<?php else: ?>
    <div class="resep-grid" id="resepGrid">
        <?php foreach ($resep_list as $i => $r):
            $is_fav = in_array($r->id_resep, $favorit_ids);
            $is_own = !empty($r->id_user);
            $has_photo = !empty($r->foto);
        ?>
            <div class="rc anim-up resep-item" data-id="<?= $r->id_resep ?>" data-nama="<?= htmlspecialchars($r->nama_resep) ?>" style="animation-delay:<?= min($i*.025,.4) ?>s">
                <!-- Photo / Emoji -->
                <div class="rc-photo" onclick="showDetail(<?= $r->id_resep ?>)">
                    <?php if ($has_photo): ?>
                        <img src="<?= base_url($r->foto) ?>" alt="<?= htmlspecialchars($r->nama_resep) ?>" loading="lazy">
                    <?php elseif (!empty($r->icon) && $r->icon != '?' && mb_strlen($r->icon) <= 4): ?>
                        <span class="rc-emoji"><?= $r->icon ?></span>
                    <?php else: ?>
                        <div class="rc-no-photo">📷<span>Belum ada foto</span></div>
                    <?php endif; ?>

                    <div class="rc-actions">
                        <button class="rc-act act-fav" onclick="event.stopPropagation();toggleFav(<?= $r->id_resep ?>,this)"><?= $is_fav ? '❤️' : '🤍' ?></button>
                        <button class="rc-act" onclick="event.stopPropagation();openEditModal(<?= $r->id_resep ?>)">✏️</button>
                        <?php if ($is_own): ?>
                            <button class="rc-act act-del" onclick="event.stopPropagation();confirmDel(<?= $r->id_resep ?>,'<?= htmlspecialchars(addslashes($r->nama_resep)) ?>')">🗑</button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="rc-body" onclick="showDetail(<?= $r->id_resep ?>)">
                    <div class="rc-kat"><?= $r->nama_kategori ?? '' ?></div>
                    <div class="rc-name"><?= htmlspecialchars($r->nama_resep) ?></div>
                    <div class="rc-meta">
                        <span class="rc-tag rc-tag-price">Rp<?= number_format($r->estimasi_harga,0,',','.') ?></span>
                        <span class="rc-tag rc-tag-time">⏱ <?= $r->waktu_masak ?>m</span>
                        <?php if ($r->is_meal_prep): ?><span class="rc-tag rc-tag-prep">📦 Prep</span><?php endif; ?>
                        <?php if (!$is_own): ?><span class="rc-tag rc-tag-sys">Default</span><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="noResults" style="display:none"><div class="mp-card mt-2"><div class="mp-card-body text-center" style="padding:2rem"><p style="font-size:2rem">🔍</p><p style="font-weight:700;color:var(--stone-600)" id="noResultsText">Tidak ditemukan</p></div></div></div>
<?php endif; ?>

<!-- MODAL: Detail -->
<div class="mo" id="detailModal">
    <div class="mo-box" style="max-width:460px">
        <div class="mo-head"><h4 id="detailTitle">...</h4><button class="mo-x" onclick="closeM('detailModal')">&times;</button></div>
        <div class="mo-body" id="detailBody"><p class="text-muted">Memuat...</p></div>
        <div style="padding:0 18px 16px;display:flex;gap:8px"><button class="btn-mp btn-outline btn-sm" style="flex:1" onclick="editFromDetail()">✏️ Edit Resep</button></div>
    </div>
</div>

<!-- MODAL: Add/Edit Form -->
<div class="mo" id="formModal">
    <div class="mo-box" style="max-width:520px">
        <div class="mo-head"><h4 id="formTitle">➕ Tambah Resep</h4><button class="mo-x" onclick="closeM('formModal')">&times;</button></div>
        <div class="mo-body">
            <form id="resepForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_resep" id="f_id">

                <!-- Photo Upload -->
                <div class="form-group">
                    <label>📷 Foto Resep</label>
                    <div class="photo-upload" id="photoUpload">
                        <img class="pu-preview" id="photoPreview">
                        <div id="photoPlaceholder">
                            <div class="pu-icon">📷</div>
                            <div class="pu-text">Klik untuk upload foto<br><span style="font-size:.65rem;color:var(--stone-300)">JPG, PNG, max 2MB</span></div>
                        </div>
                        <input type="file" name="foto" id="fotoInput" accept="image/*">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Resep *</label>
                    <input type="text" name="nama_resep" id="f_nama" class="form-input" required placeholder="cth: Ayam Kecap Manis">
                </div>
                <div class="grid-2">
                    <div class="form-group"><label>Kategori</label>
                        <select name="id_kategori" id="f_kat" class="form-input">
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k->id_kategori ?>"><?= $k->icon ?> <?= $k->nama_kategori ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Estimasi Harga (Rp)</label>
                        <input type="number" name="estimasi_harga" id="f_harga" class="form-input" value="15000" min="0" step="500">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group"><label>Porsi</label><input type="number" name="porsi" id="f_porsi" class="form-input" value="2" min="1"></div>
                    <div class="form-group"><label>Waktu Masak (menit)</label><input type="number" name="waktu_masak" id="f_waktu" class="form-input" value="30" min="1"></div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer">
                        <input type="checkbox" name="is_meal_prep" id="f_prep" value="1" style="accent-color:var(--brand);width:16px;height:16px">
                        <span>📦 Bisa Meal Prep (masak untuk 2 hari)</span>
                    </label>
                </div>

                <div style="border-top:1px solid var(--stone-100);padding-top:12px;margin-top:8px">
                    <div class="d-flex justify-between items-center mb-1">
                        <p style="font-size:.85rem;font-weight:700">🥘 Bahan-bahan</p>
                        <button type="button" class="btn-mp btn-outline btn-sm" onclick="addBahan()">+ Bahan</button>
                    </div>
                    <div class="bahan-grid" style="margin-bottom:4px"><span class="fs-xs text-muted fw-800">Nama</span><span class="fs-xs text-muted fw-800">Jml</span><span class="fs-xs text-muted fw-800">Satuan</span><span class="fs-xs text-muted fw-800">Harga</span><span></span></div>
                    <div id="bahanBox"></div>
                    <button type="button" class="btn-mp btn-ghost btn-sm w-full mt-1" style="justify-content:center;border:1px dashed var(--stone-300)" onclick="addBahan()">+ Tambah Bahan</button>
                </div>

                <div class="form-group mt-2"><label>Catatan</label><input type="text" name="catatan" id="f_catatan" class="form-input" placeholder="Tips memasak (opsional)"></div>

                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn-mp btn-outline" style="flex:1" onclick="closeM('formModal')">Batal</button>
                    <button type="submit" class="btn-mp btn-brand" style="flex:2;justify-content:center">💾 <span id="btnText">Simpan Resep</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CONFIRM DELETE -->
<div class="confirm-dialog" id="confirmDelete">
    <div class="confirm-box">
        <p style="font-size:2.5rem;margin-bottom:8px">🗑️</p>
        <h4 style="font-size:.95rem;font-weight:700;margin-bottom:4px">Hapus Resep?</h4>
        <p id="delName" style="font-size:.82rem;color:var(--stone-500);margin-bottom:16px"></p>
        <div style="display:flex;gap:8px">
            <button class="btn-mp btn-outline" style="flex:1" onclick="closeDel()">Batal</button>
            <button class="btn-mp btn-sm" id="btnDel" style="background:var(--red);color:#fff;border-color:var(--red);flex:1">🗑️ Hapus</button>
        </div>
    </div>
</div>

<script>
var curDetailId=null, delId=null;
function openM(id){document.getElementById(id).classList.add('open');}
function closeM(id){document.getElementById(id).classList.remove('open');}
document.querySelectorAll('.mo').forEach(function(m){m.addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');});});

// Search
var si=document.getElementById('searchInput'),sc=document.getElementById('searchClear');
if(si) si.addEventListener('input',function(){var q=this.value.toLowerCase().trim();sc.classList.toggle('show',q.length>0);var items=document.querySelectorAll('.resep-item'),vis=0;items.forEach(function(el){var ok=el.dataset.nama.toLowerCase().indexOf(q)>-1;el.style.display=ok?'':'none';if(ok)vis++;});var nr=document.getElementById('noResults');if(nr){nr.style.display=(vis===0&&q.length>0)?'block':'none';}});
function clearSearch(){si.value='';si.dispatchEvent(new Event('input'));si.focus();}

// Photo preview
document.getElementById('fotoInput').addEventListener('change',function(){
    var file=this.files[0];
    if(!file)return;
    var reader=new FileReader();
    reader.onload=function(e){
        var img=document.getElementById('photoPreview');
        img.src=e.target.result; img.style.display='block';
        document.getElementById('photoPlaceholder').style.display='none';
    };
    reader.readAsDataURL(file);
});

// Detail
function showDetail(id){
    curDetailId=id;openM('detailModal');
    document.getElementById('detailBody').innerHTML='<div class="text-center" style="padding:2rem"><p class="text-muted">⏳ Memuat...</p></div>';
    $.get('<?= site_url("resep/detail/") ?>'+id,function(raw){
        var r=(typeof raw==='object')?raw:JSON.parse(raw.substring(raw.indexOf('{')));
        if(!r||r.status!==0||!r.data)return;
        var d=r.data,h='';
        document.getElementById('detailTitle').textContent=d.nama_resep;
        if(d.foto) h+='<img src="<?= base_url() ?>'+d.foto+'" class="detail-photo">';
        h+='<div style="display:flex;gap:5px;flex-wrap:wrap;margin-bottom:12px">';
        h+='<span class="rc-tag rc-tag-price" style="font-size:.72rem;padding:3px 8px">Rp'+Number(d.estimasi_harga).toLocaleString('id-ID')+'</span>';
        h+='<span class="rc-tag rc-tag-time" style="font-size:.72rem;padding:3px 8px">⏱ '+d.waktu_masak+'m</span>';
        h+='<span class="rc-tag" style="font-size:.72rem;padding:3px 8px;background:var(--stone-100);color:var(--stone-500)">👥 '+d.porsi+' porsi</span>';
        if(d.is_meal_prep==1||d.is_meal_prep=='1'||d.is_meal_prep==true) h+='<span class="rc-tag rc-tag-prep" style="font-size:.72rem;padding:3px 8px">📦 Prep</span>';
        h+='</div>';
        if(d.bahan&&d.bahan.length){
            h+='<div style="background:var(--stone-50);border-radius:10px;padding:12px 14px;margin-bottom:12px">';
            h+='<p style="font-weight:700;font-size:.82rem;margin-bottom:6px">🥘 Bahan ('+d.bahan.length+'):</p>';
            d.bahan.forEach(function(b){h+='<div class="detail-bahan-row"><span style="font-weight:600">'+escHtml(b.nama_bahan)+'</span><span class="text-muted" style="font-weight:600">'+b.jumlah+' '+escHtml(b.satuan)+'</span></div>';});
            h+='</div>';
        }
        if(d.catatan) h+='<div style="background:var(--amber-soft);border-radius:8px;padding:10px 12px"><p style="font-size:.82rem;font-weight:600;color:var(--amber)">💡 '+escHtml(d.catatan)+'</p></div>';
        document.getElementById('detailBody').innerHTML=h;
    });
}
function editFromDetail(){closeM('detailModal');if(curDetailId)openEditModal(curDetailId);}

// Add
function openAddModal(){
    document.getElementById('formTitle').textContent='➕ Tambah Resep Baru';
    document.getElementById('btnText').textContent='Simpan Resep';
    document.getElementById('resepForm').action='<?= site_url("resep/simpan") ?>';
    document.getElementById('f_id').value='';
    document.getElementById('f_nama').value='';
    document.getElementById('f_kat').value='1';
    document.getElementById('f_harga').value='15000';
    document.getElementById('f_porsi').value='2';
    document.getElementById('f_waktu').value='30';
    document.getElementById('f_prep').checked=false;
    document.getElementById('f_catatan').value='';
    document.getElementById('bahanBox').innerHTML='';
    document.getElementById('photoPreview').style.display='none';
    document.getElementById('photoPlaceholder').style.display='';
    document.getElementById('fotoInput').value='';
    addBahan();openM('formModal');
}

// Edit
function openEditModal(id){
    document.getElementById('formTitle').textContent='✏️ Edit Resep';
    document.getElementById('btnText').textContent='Update Resep';
    document.getElementById('resepForm').action='<?= site_url("resep/update") ?>';
    document.getElementById('bahanBox').innerHTML='';
    document.getElementById('fotoInput').value='';
    $.get('<?= site_url("resep/detail/") ?>'+id,function(raw){
        var r=(typeof raw==='object')?raw:JSON.parse(raw.substring(raw.indexOf('{')));
        if(!r||r.status!==0||!r.data)return;
        var d=r.data;
        document.getElementById('f_id').value=d.id_resep;
        document.getElementById('f_nama').value=d.nama_resep;
        document.getElementById('f_kat').value=d.id_kategori;
        document.getElementById('f_harga').value=d.estimasi_harga;
        document.getElementById('f_porsi').value=d.porsi;
        document.getElementById('f_waktu').value=d.waktu_masak;
        document.getElementById('f_prep').checked=(d.is_meal_prep==1||d.is_meal_prep=='1'||d.is_meal_prep==true);
        document.getElementById('f_catatan').value=d.catatan||'';
        // Show existing photo
        if(d.foto){
            var img=document.getElementById('photoPreview');
            img.src='<?= base_url() ?>'+d.foto;img.style.display='block';
            document.getElementById('photoPlaceholder').style.display='none';
        } else {
            document.getElementById('photoPreview').style.display='none';
            document.getElementById('photoPlaceholder').style.display='';
        }
        if(d.bahan&&d.bahan.length){d.bahan.forEach(function(b){addBahan(b.nama_bahan,b.jumlah,b.satuan,b.harga_satuan);});}
        else{addBahan();}
        openM('formModal');
    });
}

function addBahan(n,j,s,h){
    var x='<div class="bahan-grid"><input type="text" name="nama_bahan[]" class="form-input" placeholder="Ayam" value="'+(n?n.replace(/"/g,'&quot;'):'')+'" style="font-size:.82rem"><input type="number" name="jumlah_bahan[]" class="form-input" value="'+(j||1)+'" min="0" step="0.5" style="font-size:.82rem"><input type="text" name="satuan_bahan[]" class="form-input" placeholder="gram" value="'+(s?s.replace(/"/g,'&quot;'):'')+'" style="font-size:.82rem"><input type="number" name="harga_bahan[]" class="form-input" placeholder="Rp" value="'+(h||'')+'" min="0" style="font-size:.82rem"><button type="button" class="bahan-remove" onclick="this.parentElement.remove()">✕</button></div>';
    document.getElementById('bahanBox').insertAdjacentHTML('beforeend',x);
}

function toggleFav(id,el){$.post('<?= site_url("resep/favorit") ?>',{id_resep:id},function(raw){var r=(typeof raw==='object')?raw:JSON.parse(raw);el.textContent=r.is_favorit?'❤️':'🤍';});}

function confirmDel(id,nama){delId=id;document.getElementById('delName').textContent='"'+nama+'"';document.getElementById('confirmDelete').classList.add('active');}
function closeDel(){document.getElementById('confirmDelete').classList.remove('active');delId=null;}
document.getElementById('btnDel').addEventListener('click',function(){
    if(!delId)return;
    $.post('<?= site_url("resep/hapus") ?>',{id_resep:delId},function(){
        closeDel();
        var c=document.querySelector('.resep-item[data-id="'+delId+'"]');
        if(c){c.style.transition='all .3s';c.style.opacity='0';c.style.transform='scale(.9)';setTimeout(function(){c.remove();},300);}
        delId=null;
    },'json');
});
document.getElementById('confirmDelete').addEventListener('click',function(e){if(e.target===this)closeDel();});
document.addEventListener('keydown',function(e){if(e.key==='Escape'){closeM('detailModal');closeM('formModal');closeDel();}});
</script>

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_mealplan extends CI_Controller
{

    private $id_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_mealplan', 'model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);

        // Cek login
        $this->id_user = $this->session->userdata('id_user');
        if (!$this->id_user) {
            redirect('welcome');
            return;
        }
    }

    /**
     * Get budget minggu ini, return fallback object jika gagal
     */
    private function _get_budget_safe()
    {
        $budget = $this->model->get_budget_minggu_ini($this->id_user);
        if (!$budget) {
            $settings = $this->model->get_settings($this->id_user);
            return (object)[
                'id_budget'       => 0,
                'budget_amount'   => $settings ? (float)$settings->budget_mingguan : 300000,
                'tanggal_mulai'   => date('Y-m-d', strtotime('monday this week')),
                'tanggal_selesai' => date('Y-m-d', strtotime('sunday this week')),
                'minggu_ke'       => date('W'),
                'tahun'           => date('Y'),
            ];
        }
        return $budget;
    }

    // ── HOME (redirect ke laporan saldo) ──────────────
    public function index()
    {
        $settings = $this->model->get_settings($this->id_user);
        if (!$settings) {
            redirect('setup');
            return;
        }
        redirect('laporan');
    }

    // ── DAPUR (Pengeluaran Dapur / old Dashboard) ────
    public function dapur()
    {
        $settings = $this->model->get_settings($this->id_user);
        if (!$settings) {
            redirect('setup');
            return;
        }

        $week_offset = (int)$this->input->get('week');
        $budget = $this->model->get_budget_by_offset($this->id_user, $week_offset);

        $senin  = $budget->tanggal_mulai;
        $minggu = $budget->tanggal_selesai;

        $terpakai = 0;
        $by_kat = [];
        $pengeluaran_list = [];
        if ($budget->id_budget) {
            $terpakai = $this->model->get_total_pengeluaran_minggu($this->id_user, $budget->id_budget);
            $by_kat   = $this->model->get_pengeluaran_by_kategori($this->id_user, $budget->id_budget);
            $pengeluaran_list = $this->model->get_pengeluaran_list($this->id_user, $budget->id_budget);
        }

        $budget_amount = (float)$budget->budget_amount;

        // Sisa minggu lalu
        $prev_budget = $this->model->get_budget_by_offset($this->id_user, $week_offset - 1);
        $prev_terpakai = 0;
        if ($prev_budget->id_budget) {
            $prev_terpakai = $this->model->get_total_pengeluaran_minggu($this->id_user, $prev_budget->id_budget);
        }
        $sisa_prev = (float)$prev_budget->budget_amount - $prev_terpakai;

        $jadwal = $this->model->get_jadwal_minggu($this->id_user, $senin, $minggu);
        $frekuensi   = (int)$settings->frekuensi_makan ?: 3;
        $total_slot  = 7 * $frekuensi;
        $slot_terisi = count($jadwal);

        $data = [
            'title'             => 'Dapur',
            'settings'          => $settings,
            'budget'            => $budget,
            'week_offset'       => $week_offset,
            'terpakai'          => $terpakai,
            'sisa'              => $budget_amount - $terpakai,
            'sisa_prev'         => $sisa_prev,
            'persen_budget'     => $budget_amount > 0 ? round(($terpakai / $budget_amount) * 100) : 0,
            'by_kategori'       => $by_kat,
            'pengeluaran_list'  => $pengeluaran_list,
            'total_slot'        => $total_slot,
            'slot_terisi'       => $slot_terisi,
            'is_current'        => ($week_offset == 0),
            'jadwal_hari_ini'   => array_filter($jadwal, function ($j) {
                return $j->tanggal == date('Y-m-d');
            }),
            // Fitur 4: Catatan minggu
            'catatan_minggu'    => $this->model->get_catatan_minggu($this->id_user, (int)$budget->minggu_ke, (int)$budget->tahun),
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('dapur/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    // ── SETUP ────────────────────────────────────────
    public function setup()
    {
        $settings = $this->model->get_settings($this->id_user);
        $data = [
            'title'    => 'Setup',
            'settings' => $settings,
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('setup/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function save_settings()
    {
        $data = [
            'jumlah_orang'    => $this->input->post('jumlah_orang'),
            'frekuensi_makan' => $this->input->post('frekuensi_makan'),
            'budget_mingguan' => $this->input->post('budget_mingguan'),
            'preferensi'      => json_encode($this->input->post('preferensi') ?: []),
        ];
        $this->model->save_settings($this->id_user, $data);
        $this->session->set_flashdata('success', 'Pengaturan berhasil disimpan!');
        redirect('dashboard');
    }

    // ── JADWAL MENU ──────────────────────────────────
    public function jadwal()
    {
        $offset = (int)$this->input->get('week_offset');

        // Hitung senin & minggu — hindari strtotime parsing yang ambigu
        $base_monday = strtotime('monday this week');
        $senin  = date('Y-m-d', strtotime("{$offset} weeks", $base_monday));
        $minggu = date('Y-m-d', strtotime("{$offset} weeks +6 days", $base_monday));

        $settings   = $this->model->get_settings($this->id_user);
        $jadwal     = $this->model->get_jadwal_minggu($this->id_user, $senin, $minggu);
        $resep_list = $this->model->get_all_resep($this->id_user);
        $kategori   = $this->model->get_kategori_menu();

        // Group by tanggal => waktu
        $grid = [];
        for ($d = 0; $d < 7; $d++) {
            $tgl = date('Y-m-d', strtotime($senin . " +{$d} days"));
            $grid[$tgl] = ['pagi' => null, 'siang' => null, 'malam' => null];
        }

        // Map jadwal ke grid — pastikan format tanggal sama
        foreach ($jadwal as $j) {
            $tgl_key = date('Y-m-d', strtotime($j->tanggal)); // normalize format
            if (isset($grid[$tgl_key]) && isset($grid[$tgl_key][$j->waktu_makan])) {
                $grid[$tgl_key][$j->waktu_makan] = $j;
            }
        }

        $data = [
            'title'       => 'Jadwal Menu',
            'settings'    => $settings,
            'grid'        => $grid,
            'senin'       => $senin,
            'minggu'      => $minggu,
            'week_offset' => $offset,
            'resep_list'  => $resep_list,
            'kategori'    => $kategori,
            'budget'      => $this->_get_budget_safe(),
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function simpan_jadwal()
    {
        $this->output->set_content_type('application/json');

        $tanggal     = $this->input->post('tanggal');
        $waktu_makan = $this->input->post('waktu_makan');
        $id_resep    = $this->input->post('id_resep') ?: null;
        $nama_custom = $this->input->post('nama_custom');

        if (!$tanggal || !$waktu_makan) {
            $this->output->set_output(json_encode(['status' => 1, 'message' => 'Data tidak lengkap']));
            return;
        }

        $data = [
            'id_user'     => $this->id_user,
            'tanggal'     => $tanggal,
            'waktu_makan' => $waktu_makan,
            'id_resep'    => $id_resep,
            'nama_custom' => $nama_custom,
        ];

        $id = $this->model->simpan_jadwal($data);
        $err = $this->db->error();

        $this->output->set_output(json_encode([
            'status'    => ($id > 0) ? 0 : (($err['code'] ?? 0) == 0 ? 0 : 1),
            'id_jadwal' => (int)$id,
            'db_error'  => $err,
        ]));
    }

    public function hapus_jadwal()
    {
        $this->output->set_content_type('application/json');
        $id = $this->input->post('id_jadwal');
        $this->model->hapus_jadwal($id, $this->id_user);
        $this->output->set_output(json_encode(['status' => 0]));
    }

    /**
     * Debug: cek isi tabel jadwal_menu untuk user ini
     * Akses: /index.php/C_mealplan/debug_jadwal
     */
    public function debug_jadwal()
    {
        $this->output->set_content_type('application/json');

        $base_monday = strtotime('monday this week');
        $senin  = date('Y-m-d', $base_monday);
        $minggu = date('Y-m-d', strtotime('+6 days', $base_monday));

        // Raw query langsung
        $sql = "SELECT j.*, r.nama_resep FROM jadwal_menu j LEFT JOIN resep r ON r.id_resep = j.id_resep WHERE j.id_user = ? ORDER BY j.tanggal";
        $all = $this->db->query($sql, [$this->id_user])->result();

        // Minggu ini
        $minggu_ini = $this->model->get_jadwal_minggu($this->id_user, $senin, $minggu);

        // Grid keys
        $grid_keys = [];
        for ($d = 0; $d < 7; $d++) {
            $grid_keys[] = date('Y-m-d', strtotime($senin . " +{$d} days"));
        }

        // Mapping test
        $mapping = [];
        foreach ($minggu_ini as $j) {
            $tgl_key = date('Y-m-d', strtotime($j->tanggal));
            $mapping[] = [
                'db_tanggal'  => $j->tanggal,
                'normalized'  => $tgl_key,
                'in_grid'     => in_array($tgl_key, $grid_keys),
                'waktu_makan' => $j->waktu_makan,
                'nama'        => $j->nama_resep ?? $j->nama_custom ?? '(kosong)',
            ];
        }

        $this->output->set_output(json_encode([
            'user_id'     => $this->id_user,
            'senin'       => $senin,
            'minggu'      => $minggu,
            'grid_keys'   => $grid_keys,
            'total_all'   => count($all),
            'total_week'  => count($minggu_ini),
            'mapping'     => $mapping,
            'all_jadwal'  => $all,
            'db_error'    => $this->db->error(),
            'php_version' => PHP_VERSION,
        ], JSON_PRETTY_PRINT));
    }

    public function copy_minggu_lalu()
    {
        $count = $this->model->copy_jadwal_minggu_lalu($this->id_user);
        $this->session->set_flashdata('success', "Berhasil copy {$count} menu dari minggu lalu!");
        redirect('jadwal');
    }

    /**
     * Copy menu dari minggu sebelumnya ke minggu target (untuk Rencana Makan)
     */
    public function copy_rencana()
    {
        $week_offset = (int)$this->input->post('week');

        // Target week
        $base = strtotime('monday this week');
        $target_senin = date('Y-m-d', strtotime("{$week_offset} weeks", $base));

        // Source = 1 minggu sebelum target
        $source_offset = $week_offset - 1;
        $source_senin = date('Y-m-d', strtotime("{$source_offset} weeks", $base));
        $source_minggu = date('Y-m-d', strtotime("{$source_offset} weeks +6 days", $base));

        // Ambil jadwal source
        $sql = "SELECT tanggal, waktu_makan, id_resep, nama_custom
                FROM jadwal_menu
                WHERE id_user = ? AND tanggal >= ? AND tanggal <= ?
                ORDER BY tanggal, waktu_makan";
        $source = $this->db->query($sql, [$this->id_user, $source_senin, $source_minggu])->result();

        $count = 0;
        foreach ($source as $j) {
            // Hitung offset hari dari source senin
            $day_offset = (strtotime($j->tanggal) - strtotime($source_senin)) / 86400;
            $new_tanggal = date('Y-m-d', strtotime($target_senin . " +{$day_offset} days"));

            $data = [
                'id_user'     => $this->id_user,
                'tanggal'     => $new_tanggal,
                'waktu_makan' => $j->waktu_makan,
                'id_resep'    => $j->id_resep,
                'nama_custom' => $j->nama_custom,
            ];
            $this->model->simpan_jadwal($data);
            $count++;
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'status'  => 0,
            'count'   => $count,
            'message' => "Berhasil copy {$count} menu!",
            'source'  => $source_senin . ' s/d ' . $source_minggu,
            'target'  => $target_senin,
        ]));
    }

    // ── RESEP DATABASE ───────────────────────────────
    public function resep()
    {
        $id_kat  = $this->input->get('kategori');
        $resep   = $id_kat
            ? $this->model->get_resep_by_kategori($id_kat, $this->id_user)
            : $this->model->get_all_resep($this->id_user);
        $favorit_ids = $this->model->get_favorit_ids($this->id_user);

        $data = [
            'title'       => 'Database Resep',
            'resep_list'  => $resep,
            'kategori'    => $this->model->get_kategori_menu(),
            'selected_kat' => $id_kat,
            'favorit_ids' => $favorit_ids,
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('resep/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function resep_detail($id_resep)
    {
        $resep = $this->model->get_resep_detail($id_resep);
        echo json_encode(['status' => 0, 'data' => $resep]);
    }

    public function simpan_resep()
    {
        $data = [
            'id_user'        => $this->id_user,
            'id_kategori'    => $this->input->post('id_kategori'),
            'nama_resep'     => $this->input->post('nama_resep'),
            'porsi'          => $this->input->post('porsi'),
            'estimasi_harga' => $this->input->post('estimasi_harga'),
            'waktu_masak'    => $this->input->post('waktu_masak'),
            'is_meal_prep'   => $this->input->post('is_meal_prep') ? 1 : 0,
            'catatan'        => $this->input->post('catatan'),
        ];

        // Upload foto
        $foto = $this->_upload_foto();
        if ($foto) $data['foto'] = $foto;

        $bahan = $this->_parse_bahan_input();
        $this->model->simpan_resep($data, $bahan);
        $this->session->set_flashdata('success', 'Resep berhasil disimpan!');
        redirect('resep');
    }

    public function update_resep()
    {
        $id_resep = $this->input->post('id_resep');

        $existing = $this->model->get_resep_detail($id_resep);
        if (!$existing || ($existing->id_user && $existing->id_user != $this->id_user)) {
            $this->session->set_flashdata('success', 'Tidak diizinkan mengedit resep ini.');
            redirect('resep');
            return;
        }

        $data = [
            'id_kategori'    => $this->input->post('id_kategori'),
            'nama_resep'     => $this->input->post('nama_resep'),
            'porsi'          => $this->input->post('porsi'),
            'estimasi_harga' => $this->input->post('estimasi_harga'),
            'waktu_masak'    => $this->input->post('waktu_masak'),
            'is_meal_prep'   => $this->input->post('is_meal_prep') ? 1 : 0,
            'catatan'        => $this->input->post('catatan'),
        ];

        // Upload foto (jika ada file baru)
        $foto = $this->_upload_foto();
        if ($foto) $data['foto'] = $foto;

        if (!$existing->id_user) {
            // Resep system → duplicate
            $data['id_user'] = $this->id_user;
            if (!$foto && $existing->foto) $data['foto'] = $existing->foto;
            $bahan = $this->_parse_bahan_input();
            $this->model->simpan_resep($data, $bahan);
            $this->session->set_flashdata('success', 'Resep disalin & diperbarui!');
        } else {
            $bahan = $this->_parse_bahan_input();
            $this->model->update_resep($id_resep, $data, $bahan);
            $this->session->set_flashdata('success', 'Resep berhasil diperbarui!');
        }
        redirect('resep');
    }

    /**
     * Upload foto resep
     */
    private function _upload_foto()
    {
        if (empty($_FILES['foto']['name'])) return null;

        $upload_dir = FCPATH . 'uploads/resep/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $config = [
            'upload_path'   => $upload_dir,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size'      => 2048, // 2MB
            'encrypt_name'  => TRUE,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto')) {
            $file = $this->upload->data();
            return 'uploads/resep/' . $file['file_name'];
        }
        return null;
    }

    public function hapus_resep()
    {
        $id_resep = $this->input->post('id_resep');
        $this->model->hapus_resep($id_resep, $this->id_user);
        echo json_encode(['status' => 0]);
    }

    /**
     * Helper: parse bahan input dari form
     */
    private function _parse_bahan_input()
    {
        $bahan = [];
        $nama_bahan = $this->input->post('nama_bahan');
        $jumlah     = $this->input->post('jumlah_bahan');
        $satuan     = $this->input->post('satuan_bahan');
        $harga      = $this->input->post('harga_bahan');

        if ($nama_bahan) {
            for ($i = 0; $i < count($nama_bahan); $i++) {
                if (empty($nama_bahan[$i])) continue;
                $bahan[] = [
                    'nama_bahan'   => $nama_bahan[$i],
                    'jumlah'       => $jumlah[$i] ?? 1,
                    'satuan'       => $satuan[$i] ?? 'buah',
                    'harga_satuan' => $harga[$i] ?? 0,
                ];
            }
        }
        return $bahan;
    }

    public function toggle_favorit()
    {
        $id_resep = $this->input->post('id_resep');
        $result = $this->model->toggle_favorit($this->id_user, $id_resep);
        echo json_encode(['status' => 0, 'is_favorit' => $result]);
    }

    // ── DAFTAR BELANJA ───────────────────────────────
    public function belanja()
    {
        $bulan = (int)$this->input->get('bulan') ?: (int)date('m');
        $tahun = (int)$this->input->get('tahun') ?: (int)date('Y');

        // Fitur 2: Auto-generate pengeluaran rutin
        $this->model->auto_generate_rutin($this->id_user, $bulan, $tahun);

        // Monthly budget
        $budget_bln = $this->model->get_budget_bulanan($this->id_user, $bulan, $tahun);

        // Belanja items this month
        $items = $this->model->get_daftar_belanja_bulan($this->id_user, $bulan, $tahun);

        // Totals
        $total_belanja = 0;
        foreach ($items as $it) $total_belanja += (float)$it->estimasi_harga;

        // Pengeluaran lain this month
        $pengeluaran_lain = $this->model->get_pengeluaran_lain_bulan($this->id_user, $bulan, $tahun);
        $total_lain = 0;
        foreach ($pengeluaran_lain as $pl) $total_lain += (float)$pl->jumlah;

        // Fitur 5: Templates
        $templates = $this->model->get_templates($this->id_user);

        $data = [
            'title'            => 'Daftar Belanja',
            'budget_bln'       => $budget_bln,
            'items'            => $items,
            'total_belanja'    => $total_belanja,
            'pengeluaran_lain' => $pengeluaran_lain,
            'total_lain'       => $total_lain,
            'templates'        => $templates,
            'bulan'            => $bulan,
            'tahun'            => $tahun,
            'is_current'       => ($bulan == (int)date('m') && $tahun == (int)date('Y')),
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('belanja/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function generate_belanja()
    {
        $budget = $this->_get_budget_safe();
        if (!$budget->id_budget) {
            $this->session->set_flashdata('success', 'Silakan isi setup terlebih dahulu.');
            redirect('setup');
            return;
        }
        $count  = $this->model->generate_daftar_belanja(
            $this->id_user,
            $budget->id_budget,
            $budget->tanggal_mulai,
            $budget->tanggal_selesai
        );
        $this->session->set_flashdata('success', "Daftar belanja dibuat ({$count} item)!");
        redirect('belanja');
    }

    public function toggle_belanja()
    {
        $id = $this->input->post('id_belanja');
        $this->model->toggle_belanja($id, $this->id_user);
        echo json_encode(['status' => 0]);
    }

    public function tambah_belanja()
    {
        $tgl = $this->input->post('tanggal_belanja') ?: date('Y-m-d');
        $data = [
            'id_user'        => $this->id_user,
            'nama_item'      => $this->input->post('nama_item'),
            'jumlah'         => $this->input->post('jumlah') ?: 1,
            'satuan'         => $this->input->post('satuan') ?: 'buah',
            'estimasi_harga' => $this->input->post('estimasi_harga') ?: 0,
            'kategori_item'  => $this->input->post('kategori_item'),
            'created_at'     => $tgl . ' ' . date('H:i:s'),
        ];
        $this->db->insert('daftar_belanja', $data);
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        $this->session->set_flashdata('success', 'Item belanja ditambahkan!');
        redirect('belanja?bulan=' . $bulan . '&tahun=' . $tahun);
    }

    public function hapus_belanja()
    {
        $id = $this->input->post('id_belanja');
        $this->db->where(['id_belanja' => $id, 'id_user' => $this->id_user])->delete('daftar_belanja');
        echo json_encode(['status' => 0]);
    }

    // ── PENGELUARAN ──────────────────────────────────
    public function pengeluaran()
    {
        redirect('dapur');
    }

    public function simpan_pengeluaran()
    {
        $budget = $this->_get_budget_safe();
        $week = (int)$this->input->post('week_offset');
        $data = [
            'id_user'     => $this->id_user,
            'id_budget'   => $budget->id_budget,
            'nama_barang' => $this->input->post('nama_barang'),
            'harga'       => $this->input->post('harga'),
            'kategori'    => $this->input->post('kategori'),
            'tanggal'     => $this->input->post('tanggal') ?: date('Y-m-d'),
            'catatan'     => $this->input->post('catatan'),
        ];
        $this->model->simpan_pengeluaran($data);
        $this->session->set_flashdata('success', 'Pengeluaran dicatat!');
        redirect('dapur?week=' . $week);
    }

    public function hapus_pengeluaran()
    {
        $id = $this->input->post('id_pengeluaran');
        $this->model->hapus_pengeluaran($id, $this->id_user);
        echo json_encode(['status' => 0]);
    }

    public function update_pengeluaran()
    {
        $id = $this->input->post('id_pengeluaran');
        $week = (int)$this->input->post('week_offset');
        $data = [
            'nama_barang' => $this->input->post('nama_barang'),
            'harga'       => $this->input->post('harga'),
            'kategori'    => $this->input->post('kategori'),
            'tanggal'     => $this->input->post('tanggal'),
            'catatan'     => $this->input->post('catatan'),
        ];
        $this->db->where(['id_pengeluaran' => $id, 'id_user' => $this->id_user])->update('pengeluaran', $data);
        $this->session->set_flashdata('success', 'Pengeluaran diperbarui!');
        redirect('dapur?week=' . $week);
    }

    public function update_belanja()
    {
        $id = $this->input->post('id_belanja');
        $tgl = $this->input->post('tanggal_belanja');
        $data = [
            'nama_item'      => $this->input->post('nama_item'),
            'jumlah'         => $this->input->post('jumlah'),
            'satuan'         => $this->input->post('satuan'),
            'estimasi_harga' => $this->input->post('estimasi_harga'),
            'kategori_item'  => $this->input->post('kategori_item'),
        ];
        if ($tgl) $data['created_at'] = $tgl . ' ' . date('H:i:s');
        $this->db->where(['id_belanja' => $id, 'id_user' => $this->id_user])->update('daftar_belanja', $data);
        $this->session->set_flashdata('success', 'Item belanja diperbarui!');
        redirect('belanja');
    }

    public function update_pengeluaran_lain()
    {
        $id = $this->input->post('id_pengeluaran_lain');
        $data = [
            'nama'     => $this->input->post('nama'),
            'jumlah'   => $this->input->post('jumlah'),
            'kategori' => $this->input->post('kategori'),
            'tanggal'  => $this->input->post('tanggal'),
            'catatan'  => $this->input->post('catatan'),
            'is_rutin' => $this->input->post('is_rutin') ? 1 : 0,
        ];
        $this->db->where(['id_pengeluaran_lain' => $id, 'id_user' => $this->id_user])->update('pengeluaran_lain', $data);
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        $this->session->set_flashdata('success', 'Pengeluaran lain diperbarui!');
        redirect('belanja?bulan=' . $bulan . '&tahun=' . $tahun);
    }

    // ── BUDGET UPDATE (AJAX) ────────────────────────────
    public function update_budget_dapur()
    {
        $id     = $this->input->post('id_budget');
        $amount = $this->input->post('amount');
        $this->model->update_budget_amount($id, $this->id_user, $amount);
        echo json_encode(['status' => 0]);
    }

    public function update_budget_bulanan()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $data = [];
        if ($this->input->post('budget_belanja') !== null) $data['budget_belanja'] = $this->input->post('budget_belanja');
        if ($this->input->post('budget_lainnya') !== null) $data['budget_lainnya'] = $this->input->post('budget_lainnya');
        $this->model->update_budget_bulanan($this->id_user, $bulan, $tahun, $data);
        echo json_encode(['status' => 0]);
    }

    // ── LAPORAN ──────────────────────────────────────
    public function laporan()
    {
        $bulan = (int)$this->input->get('bulan') ?: (int)date('m');
        $tahun = (int)$this->input->get('tahun') ?: (int)date('Y');
        $tab   = $this->input->get('tab') ?: 'saldo';

        $laporan   = $this->model->get_laporan_by_bulan($this->id_user, $bulan, $tahun);
        $ringkasan = $this->model->get_ringkasan_bulanan($this->id_user, $bulan, $tahun);
        $bulan_list = $this->model->get_bulan_tersedia($this->id_user);

        // Pemasukan & Saldo
        $pemasukan_list = $this->model->get_pemasukan_bulan($this->id_user, $bulan, $tahun);
        $saldo = $this->model->get_ringkasan_saldo_bulanan($this->id_user, $bulan, $tahun);

        // Belanja bulanan (dari daftar_belanja)
        $tgl_awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));
        $sql_bl = "SELECT COALESCE(kategori_item, 'lainnya') as kategori,
                          COALESCE(SUM(estimasi_harga), 0) as total, COUNT(*) as jumlah,
                          SUM(CASE WHEN is_checked = 1 THEN 1 ELSE 0 END) as sudah
                   FROM daftar_belanja
                   WHERE id_user = ? AND created_at >= ? AND created_at <= CONCAT(?, ' 23:59:59')
                   GROUP BY kategori_item ORDER BY total DESC";
        $belanja_per_kat = $this->db->query($sql_bl, [$this->id_user, $tgl_awal, $tgl_akhir])->result();

        $sql_bl_total = "SELECT COALESCE(SUM(estimasi_harga), 0) as total, COUNT(*) as total_item,
                                SUM(CASE WHEN is_checked = 1 THEN 1 ELSE 0 END) as sudah_beli,
                                COALESCE(SUM(CASE WHEN is_checked = 1 THEN estimasi_harga ELSE 0 END), 0) as total_sudah
                         FROM daftar_belanja
                         WHERE id_user = ? AND created_at >= ? AND created_at <= CONCAT(?, ' 23:59:59')";
        $bl_total = $this->db->query($sql_bl_total, [$this->id_user, $tgl_awal, $tgl_akhir])->row();

        $data = [
            'title'           => 'Home',
            'laporan'         => $laporan,
            'ringkasan'       => $ringkasan,
            'bulan'           => $bulan,
            'tahun'           => $tahun,
            'bulan_list'      => $bulan_list,
            'active_tab'      => $tab,
            'pemasukan_list'  => $pemasukan_list,
            'saldo'           => $saldo,
            'belanja_per_kat' => $belanja_per_kat,
            'bl_total'        => $bl_total,
            // Fitur 1: Tren & Alerts
            'tren'            => $this->model->get_tren_3bulan($this->id_user),
            'alerts'          => $this->model->get_budget_alerts($this->id_user),
            // Fitur 7: Tabungan
            'tabungan'        => $this->model->get_tabungan($this->id_user),
            'total_sisa_all'  => $this->model->get_total_sisa_bulanan($this->id_user),
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    // ── API: Rekomendasi Menu Otomatis ───────────────
    public function rekomendasi_menu()
    {
        $settings  = $this->model->get_settings($this->id_user);
        $budget    = $settings->budget_mingguan;
        $orang     = $settings->jumlah_orang;
        $frekuensi = $settings->frekuensi_makan;
        $preferensi = json_decode($settings->preferensi, true) ?: [];

        $all_resep = $this->model->get_all_resep($this->id_user);
        $budget_per_meal = $budget / (7 * $frekuensi);

        // Filter resep sesuai budget per meal dan preferensi
        $filtered = array_filter($all_resep, function ($r) use ($budget_per_meal) {
            return $r->estimasi_harga <= ($budget_per_meal * 1.3);
        });
        $filtered = array_values($filtered);

        // Distribute randomly across the week
        $senin = date('Y-m-d', strtotime('monday this week'));
        $waktu_list = ['pagi', 'siang', 'malam'];
        if ($frekuensi == 2) $waktu_list = ['pagi', 'malam'];

        $rekomendasi = [];
        $total_cost = 0;

        for ($d = 0; $d < 7; $d++) {
            $tgl = date('Y-m-d', strtotime($senin . " +{$d} days"));
            foreach ($waktu_list as $waktu) {
                if (empty($filtered)) break;
                $pick = $filtered[array_rand($filtered)];
                $rekomendasi[] = [
                    'tanggal'     => $tgl,
                    'waktu_makan' => $waktu,
                    'id_resep'    => $pick->id_resep,
                    'nama_resep'  => $pick->nama_resep,
                    'harga'       => $pick->estimasi_harga,
                    'icon'        => $pick->icon,
                ];
                $total_cost += $pick->estimasi_harga;
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'status'       => 0,
            'rekomendasi'  => $rekomendasi,
            'total_cost'   => $total_cost,
            'budget'       => $budget,
        ]));
    }

    public function apply_rekomendasi()
    {
        $this->output->set_content_type('application/json');
        $items = json_decode($this->input->post('items'), true);
        if ($items) {
            foreach ($items as $item) {
                $this->model->simpan_jadwal([
                    'id_user'     => $this->id_user,
                    'tanggal'     => $item['tanggal'],
                    'waktu_makan' => $item['waktu_makan'],
                    'id_resep'    => $item['id_resep'],
                ]);
            }
        }
        $this->output->set_output(json_encode(['status' => 0, 'message' => 'Menu diterapkan!']));
    }

    // ── MASTER HARGA ─────────────────────────────────
    public function master_harga()
    {
        $kat = $this->input->get('kategori');
        $list = $this->model->get_all_harga($this->id_user, $kat);
        $kategori_list = $this->model->get_kategori_bahan($this->id_user);

        $data = [
            'title'        => 'Master Harga',
            'list'         => $list,
            'kategori_list' => $kategori_list,
            'selected_kat' => $kat,
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('harga/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function simpan_harga()
    {
        $data = [
            'id_user'       => $this->id_user,
            'nama_bahan'    => $this->input->post('nama_bahan'),
            'harga_satuan'  => $this->input->post('harga_satuan'),
            'satuan'        => $this->input->post('satuan'),
            'kategori_bahan' => $this->input->post('kategori_bahan'),
            'catatan'       => $this->input->post('catatan'),
        ];
        $this->model->simpan_harga($data);
        $this->session->set_flashdata('success', 'Harga baru ditambahkan!');
        redirect('master-harga');
    }

    public function update_harga()
    {
        $id = $this->input->post('id_harga');
        $data = [
            'nama_bahan'    => $this->input->post('nama_bahan'),
            'harga_satuan'  => $this->input->post('harga_satuan'),
            'satuan'        => $this->input->post('satuan'),
            'kategori_bahan' => $this->input->post('kategori_bahan'),
            'catatan'       => $this->input->post('catatan'),
        ];
        $this->model->update_harga($id, $this->id_user, $data);
        $this->session->set_flashdata('success', 'Harga berhasil diupdate!');
        redirect('master-harga');
    }

    public function hapus_harga()
    {
        $id = $this->input->post('id_harga');
        $this->model->hapus_harga($id, $this->id_user);
        echo json_encode(['status' => 0]);
    }

    public function search_harga()
    {
        $q = $this->input->get('q');
        $results = $this->model->cari_harga_bahan($this->id_user, $q);
        echo json_encode(['status' => 0, 'data' => $results]);
    }

    // ── RENCANA MAKAN (Modul baru) ──────────────────
    public function rencana_makan()
    {
        $offset = (int)$this->input->get('week');

        // Hitung senin & minggu
        $base = strtotime('monday this week');
        $senin  = date('Y-m-d', strtotime("{$offset} weeks", $base));
        $minggu_end = date('Y-m-d', strtotime("{$offset} weeks +6 days", $base));

        // Raw SQL langsung — bypass semua CI query builder
        $sql = "SELECT j.id_jadwal, j.tanggal, j.waktu_makan, j.nama_custom,
                       r.nama_resep, r.estimasi_harga, r.waktu_masak, r.porsi,
                       k.icon, k.nama_kategori
                FROM jadwal_menu j
                LEFT JOIN resep r ON r.id_resep = j.id_resep
                LEFT JOIN kategori_menu k ON k.id_kategori = r.id_kategori
                WHERE j.id_user = ? AND j.tanggal >= ? AND j.tanggal <= ?
                ORDER BY j.tanggal ASC, 
                    CASE j.waktu_makan WHEN 'pagi' THEN 1 WHEN 'siang' THEN 2 WHEN 'malam' THEN 3 ELSE 4 END";
        $jadwal = $this->db->query($sql, [$this->id_user, $senin, $minggu_end])->result();

        // Group per hari
        $per_hari = [];
        $total_est = 0;
        foreach ($jadwal as $j) {
            $tgl = date('Y-m-d', strtotime($j->tanggal));
            if (!isset($per_hari[$tgl])) $per_hari[$tgl] = [];
            $per_hari[$tgl][] = $j;
            $total_est += (float)($j->estimasi_harga ?? 0);
        }

        // Semua tanggal dalam minggu (termasuk yang kosong)
        $hari_list = [];
        for ($d = 0; $d < 7; $d++) {
            $tgl = date('Y-m-d', strtotime($senin . " +{$d} days"));
            $hari_list[$tgl] = $per_hari[$tgl] ?? [];
        }

        $settings = $this->model->get_settings($this->id_user);
        $budget = $this->_get_budget_safe();
        $resep_list = $this->model->get_all_resep($this->id_user);
        $kategori = $this->model->get_kategori_menu();

        $data = [
            'title'       => 'Rencana Makan',
            'senin'       => $senin,
            'minggu_end'  => $minggu_end,
            'week_offset' => $offset,
            'hari_list'   => $hari_list,
            'total_jadwal' => count($jadwal),
            'total_est'   => $total_est,
            'settings'    => $settings,
            'budget'      => $budget,
            'resep_list'  => $resep_list,
            'kategori'    => $kategori,
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('rencana/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    // ── PEMASUKAN BULANAN ─────────────────────────────
    public function pemasukan()
    {
        $bulan = (int)$this->input->get('bulan') ?: (int)date('m');
        $tahun = (int)$this->input->get('tahun') ?: (int)date('Y');

        $list  = $this->model->get_pemasukan_bulan($this->id_user, $bulan, $tahun);
        $total = $this->model->get_total_pemasukan_bulan($this->id_user, $bulan, $tahun);
        $saldo = $this->model->get_ringkasan_saldo_bulanan($this->id_user, $bulan, $tahun);

        $data = [
            'title' => 'Pemasukan',
            'list'  => $list,
            'total' => $total,
            'saldo' => $saldo,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('pemasukan_bulanan/index', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function simpan_pemasukan_bulanan()
    {
        $bulan = (int)$this->input->post('bulan') ?: (int)date('m');
        $tahun = (int)$this->input->post('tahun') ?: (int)date('Y');

        $data = [
            'id_user' => $this->id_user,
            'bulan'   => $bulan,
            'tahun'   => $tahun,
            'sumber'  => $this->input->post('sumber'),
            'jumlah'  => $this->input->post('jumlah'),
            'catatan' => $this->input->post('catatan'),
            'tanggal' => $this->input->post('tanggal') ?: date('Y-m-d'),
        ];
        $this->model->simpan_pemasukan($data);
        $this->session->set_flashdata('success', 'Pemasukan berhasil ditambahkan!');
        redirect('pemasukan?bulan=' . $bulan . '&tahun=' . $tahun);
    }

    public function hapus_pemasukan_bulanan()
    {
        $id    = $this->input->post('id_pemasukan');
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        $this->model->hapus_pemasukan($id, $this->id_user);
        echo json_encode(['status' => 0]);
    }

    // ── PENGELUARAN LAIN (Listrik, BPJS, dll) ────────
    public function simpan_pengeluaran_lain()
    {
        $data = [
            'id_user'  => $this->id_user,
            'nama'     => $this->input->post('nama'),
            'jumlah'   => $this->input->post('jumlah'),
            'kategori' => $this->input->post('kategori') ?: 'lainnya',
            'tanggal'  => $this->input->post('tanggal') ?: date('Y-m-d'),
            'catatan'  => $this->input->post('catatan'),
            'is_rutin' => $this->input->post('is_rutin') ? 1 : 0,
        ];
        $this->model->simpan_pengeluaran_lain($data);
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        $this->session->set_flashdata('success', 'Pengeluaran berhasil dicatat!');
        redirect('belanja?bulan=' . $bulan . '&tahun=' . $tahun);
    }

    public function hapus_pengeluaran_lain()
    {
        $id = $this->input->post('id');
        $this->model->hapus_pengeluaran_lain($id, $this->id_user);
        echo json_encode(['status' => 0]);
    }

    // ══════════════════════════════════════════════════
    // FITUR 4: Catatan Minggu (AJAX)
    // ══════════════════════════════════════════════════
    public function save_catatan()
    {
        $minggu_ke = $this->input->post('minggu_ke');
        $tahun = $this->input->post('tahun');
        $catatan = $this->input->post('catatan');
        $this->model->save_catatan_minggu($this->id_user, $minggu_ke, $tahun, $catatan);
        echo json_encode(['status' => 0]);
    }

    // ══════════════════════════════════════════════════
    // FITUR 5: Template Belanja
    // ══════════════════════════════════════════════════
    public function save_template()
    {
        $nama = $this->input->post('nama_template') ?: 'Belanja Mingguan';
        $items_json = $this->input->post('items');
        $items = json_decode($items_json, true) ?: [];
        if (empty($items)) {
            echo json_encode(['status' => 1, 'msg' => 'Tidak ada item']);
            return;
        }
        $this->model->save_template($this->id_user, $nama, $items);
        echo json_encode(['status' => 0]);
    }

    public function apply_template()
    {
        $id = $this->input->post('id_template');
        $count = $this->model->apply_template($this->id_user, $id);
        $this->session->set_flashdata('success', "Template diterapkan ({$count} item)!");
        redirect('belanja');
    }

    public function delete_template()
    {
        $id = $this->input->post('id_template');
        $this->model->delete_template($id, $this->id_user);
        echo json_encode(['status' => 0]);
    }

    // ══════════════════════════════════════════════════
    // FITUR 3: Export Laporan
    // ══════════════════════════════════════════════════
    public function export_laporan()
    {
        $bulan = (int)$this->input->get('bulan') ?: (int)date('m');
        $tahun = (int)$this->input->get('tahun') ?: (int)date('Y');
        $nama_bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        $saldo = $this->model->get_ringkasan_saldo_bulanan($this->id_user, $bulan, $tahun);

        $tgl_awal = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));
        $dapur_list = $this->db->where('id_user', $this->id_user)
            ->where('tanggal >=', $tgl_awal)->where('tanggal <=', $tgl_akhir)
            ->order_by('tanggal ASC')->get('pengeluaran')->result();

        $belanja = $this->model->get_daftar_belanja_bulan($this->id_user, $bulan, $tahun);
        $pl = $this->model->get_pengeluaran_lain_bulan($this->id_user, $bulan, $tahun);

        $data = [
            'bulan' => $bulan, 'tahun' => $tahun,
            'nama_bulan' => $nama_bulan,
            'saldo' => $saldo,
            'dapur_list' => $dapur_list,
            'belanja' => $belanja,
            'pengeluaran_lain' => $pl,
            'user_name' => $this->session->userdata('nama_user') ?: 'User',
        ];
        $this->load->view('laporan/export_pdf', $data);
    }


    // ══════════════════════════════════════════════════
    // FITUR 7: Target Tabungan
    // ══════════════════════════════════════════════════
    public function save_tabungan()
    {
        $nama = $this->input->post('nama_target') ?: 'Tabungan';
        $target = $this->input->post('target_amount') ?: 0;
        $this->model->save_tabungan($this->id_user, $nama, $target);
        echo json_encode(['status' => 0]);
    }

    public function delete_tabungan()
    {
        $id = $this->input->post('id');
        $this->model->delete_tabungan($id, $this->id_user);
        echo json_encode(['status' => 0]);
    }
}

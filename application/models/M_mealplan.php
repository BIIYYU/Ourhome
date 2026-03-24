<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_mealplan extends CI_Model
{

    // ── USER & SETTINGS ──────────────────────────────
    public function get_user($id_user)
    {
        return $this->db->get_where('users', ['id_user' => $id_user])->row();
    }

    public function get_settings($id_user)
    {
        return $this->db->get_where('user_settings', ['id_user' => $id_user])->row();
    }

    public function save_settings($id_user, $data)
    {
        $exists = $this->get_settings($id_user);
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($exists) {
            $this->db->where('id_user', $id_user)->update('user_settings', $data);
        } else {
            $data['id_user'] = $id_user;
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('user_settings', $data);
        }
        return true;
    }

    // ── DASHBOARD SUMMARY ────────────────────────────
    public function get_budget_minggu_ini($id_user)
    {
        $minggu = date('W');
        $tahun  = date('Y');
        $row = $this->db->get_where('budget_minggu', [
            'id_user'  => $id_user,
            'minggu_ke' => $minggu,
            'tahun'    => $tahun
        ])->row();

        if (!$row) {
            $settings = $this->get_settings($id_user);
            $budget = $settings ? $settings->budget_mingguan : 300000;
            $senin  = date('Y-m-d', strtotime('monday this week'));
            $minggu_akhir = date('Y-m-d', strtotime('sunday this week'));

            $this->db->insert('budget_minggu', [
                'id_user'         => $id_user,
                'minggu_ke'       => $minggu,
                'tahun'           => $tahun,
                'tanggal_mulai'   => $senin,
                'tanggal_selesai' => $minggu_akhir,
                'budget_amount'   => $budget
            ]);
            $row = $this->db->get_where('budget_minggu', [
                'id_user' => $id_user, 'minggu_ke' => $minggu, 'tahun' => $tahun
            ])->row();
        }
        return $row;
    }

    /**
     * Get budget for any week (offset from current week)
     */
    public function get_budget_by_offset($id_user, $week_offset = 0)
    {
        $base = strtotime('monday this week');
        $senin = date('Y-m-d', strtotime("{$week_offset} weeks", $base));
        $minggu_end = date('Y-m-d', strtotime("{$week_offset} weeks +6 days", $base));
        $minggu_ke = (int)date('W', strtotime($senin));
        $tahun = (int)date('Y', strtotime($senin));

        $row = $this->db->get_where('budget_minggu', [
            'id_user' => $id_user, 'minggu_ke' => $minggu_ke, 'tahun' => $tahun
        ])->row();

        if (!$row && $week_offset <= 0) {
            // Auto-create only for current or past weeks
            $settings = $this->get_settings($id_user);
            $budget = $settings ? $settings->budget_mingguan : 300000;
            $this->db->insert('budget_minggu', [
                'id_user' => $id_user, 'minggu_ke' => $minggu_ke, 'tahun' => $tahun,
                'tanggal_mulai' => $senin, 'tanggal_selesai' => $minggu_end,
                'budget_amount' => $budget,
            ]);
            $row = $this->db->get_where('budget_minggu', [
                'id_user' => $id_user, 'minggu_ke' => $minggu_ke, 'tahun' => $tahun
            ])->row();
        }

        if (!$row) {
            // Return placeholder for future weeks
            $settings = $this->get_settings($id_user);
            return (object)[
                'id_budget' => 0, 'id_user' => $id_user,
                'minggu_ke' => $minggu_ke, 'tahun' => $tahun,
                'tanggal_mulai' => $senin, 'tanggal_selesai' => $minggu_end,
                'budget_amount' => $settings ? $settings->budget_mingguan : 300000,
            ];
        }
        return $row;
    }

    /**
     * Update budget amount
     */
    public function update_budget_amount($id_budget, $id_user, $amount)
    {
        $this->db->where(['id_budget' => $id_budget, 'id_user' => $id_user])
            ->update('budget_minggu', ['budget_amount' => $amount]);
    }

    // ── BUDGET BULANAN ────────────────────────────────

    public function get_budget_bulanan($id_user, $bulan, $tahun)
    {
        $row = $this->db->get_where('budget_bulanan', [
            'id_user' => $id_user, 'bulan' => $bulan, 'tahun' => $tahun
        ])->row();

        if (!$row) {
            $this->db->insert('budget_bulanan', [
                'id_user' => $id_user, 'bulan' => $bulan, 'tahun' => $tahun,
                'budget_belanja' => 500000, 'budget_lainnya' => 500000,
            ]);
            $row = $this->db->get_where('budget_bulanan', [
                'id_user' => $id_user, 'bulan' => $bulan, 'tahun' => $tahun
            ])->row();
        }
        return $row;
    }

    public function update_budget_bulanan($id_user, $bulan, $tahun, $data)
    {
        $this->db->where(['id_user' => $id_user, 'bulan' => $bulan, 'tahun' => $tahun])
            ->update('budget_bulanan', $data);
    }

    /**
     * Get belanja items by month (not by budget_minggu)
     */
    public function get_daftar_belanja_bulan($id_user, $bulan, $tahun)
    {
        $tgl_awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));
        $this->db->where('id_user', $id_user);
        $this->db->where('created_at >=', $tgl_awal);
        $this->db->where('created_at <=', $tgl_akhir . ' 23:59:59');
        $this->db->order_by('created_at DESC');
        return $this->db->get('daftar_belanja')->result();
    }

    public function get_total_pengeluaran_minggu($id_user, $id_budget)
    {
        $this->db->select_sum('harga');
        $this->db->where(['id_user' => $id_user, 'id_budget' => $id_budget]);
        $row = $this->db->get('pengeluaran')->row();
        return $row ? (float)$row->harga : 0;
    }

    /**
     * Total estimasi harga dari jadwal menu (resep yang dipilih) dalam 1 minggu
     */
    public function get_total_estimasi_menu($id_user, $tanggal_mulai, $tanggal_selesai)
    {
        $sql = "SELECT COALESCE(SUM(r.estimasi_harga), 0) as total
                FROM jadwal_menu j
                LEFT JOIN resep r ON r.id_resep = j.id_resep
                WHERE j.id_user = ? AND j.tanggal >= ? AND j.tanggal <= ?";
        $row = $this->db->query($sql, [$id_user, $tanggal_mulai, $tanggal_selesai])->row();
        return $row ? (float)$row->total : 0;
    }

    public function get_pengeluaran_by_kategori($id_user, $id_budget)
    {
        $this->db->select('kategori, SUM(harga) as total');
        $this->db->where(['id_user' => $id_user, 'id_budget' => $id_budget]);
        $this->db->group_by('kategori');
        $this->db->order_by('total', 'DESC');
        return $this->db->get('pengeluaran')->result();
    }

    // ── RESEP ────────────────────────────────────────
    public function get_all_resep($id_user = null)
    {
        $this->db->select('r.*, k.nama_kategori, k.icon');
        $this->db->from('resep r');
        $this->db->join('kategori_menu k', 'k.id_kategori = r.id_kategori', 'left');
        $this->db->where('(r.id_user IS NULL OR r.id_user = ' . (int)$id_user . ')');
        $this->db->order_by('k.urutan, r.nama_resep');
        return $this->db->get()->result();
    }

    public function get_resep_by_kategori($id_kategori, $id_user = null)
    {
        $this->db->select('r.*, k.nama_kategori, k.icon');
        $this->db->from('resep r');
        $this->db->join('kategori_menu k', 'k.id_kategori = r.id_kategori', 'left');
        $this->db->where('r.id_kategori', $id_kategori);
        $this->db->where('(r.id_user IS NULL OR r.id_user = ' . (int)$id_user . ')');
        return $this->db->get()->result();
    }

    public function get_resep_detail($id_resep)
    {
        $resep = $this->db->select('r.*, k.nama_kategori, k.icon')
            ->from('resep r')
            ->join('kategori_menu k', 'k.id_kategori = r.id_kategori', 'left')
            ->where('r.id_resep', $id_resep)
            ->get()->row();
        if ($resep) {
            $resep->bahan = $this->db->where('id_resep', $id_resep)
                ->order_by('urutan')->get('bahan_resep')->result();
        }
        return $resep;
    }

    public function get_kategori_menu()
    {
        return $this->db->order_by('urutan')->get('kategori_menu')->result();
    }

    public function simpan_resep($data, $bahan_list)
    {
        $this->db->insert('resep', $data);
        $id_resep = $this->db->insert_id();
        foreach ($bahan_list as $i => $b) {
            $b['id_resep'] = $id_resep;
            $b['urutan'] = $i + 1;
            $this->db->insert('bahan_resep', $b);
        }
        return $id_resep;
    }

    public function update_resep($id_resep, $data, $bahan_list)
    {
        $this->db->where('id_resep', $id_resep)->update('resep', $data);

        // Delete old bahan, insert new
        $this->db->where('id_resep', $id_resep)->delete('bahan_resep');
        foreach ($bahan_list as $i => $b) {
            $b['id_resep'] = $id_resep;
            $b['urutan'] = $i + 1;
            $this->db->insert('bahan_resep', $b);
        }
        return true;
    }

    public function hapus_resep($id_resep, $id_user)
    {
        // Hanya hapus resep milik user (bukan system)
        $this->db->where(['id_resep' => $id_resep, 'id_user' => $id_user])->delete('resep');
    }

    // ── JADWAL MENU ──────────────────────────────────
    public function get_jadwal_minggu($id_user, $tanggal_mulai, $tanggal_selesai)
    {
        $sql = "SELECT j.*, r.nama_resep, r.estimasi_harga, r.waktu_masak, k.icon
                FROM jadwal_menu j
                LEFT JOIN resep r ON r.id_resep = j.id_resep
                LEFT JOIN kategori_menu k ON k.id_kategori = r.id_kategori
                WHERE j.id_user = ? AND j.tanggal >= ? AND j.tanggal <= ?
                ORDER BY j.tanggal,
                    CASE j.waktu_makan
                        WHEN 'pagi' THEN 1
                        WHEN 'siang' THEN 2
                        WHEN 'malam' THEN 3
                        ELSE 4
                    END";
        return $this->db->query($sql, [$id_user, $tanggal_mulai, $tanggal_selesai])->result();
    }

    public function simpan_jadwal($data)
    {
        // Always INSERT — support multiple lauk per waktu makan
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('jadwal_menu', $data);
        return $this->db->insert_id();
    }

    public function hapus_jadwal($id_jadwal, $id_user)
    {
        $this->db->where(['id_jadwal' => $id_jadwal, 'id_user' => $id_user])->delete('jadwal_menu');
    }

    public function copy_jadwal_minggu_lalu($id_user)
    {
        $senin_lalu = date('Y-m-d', strtotime('monday last week'));
        $minggu_lalu = date('Y-m-d', strtotime('sunday last week'));
        $senin_ini = date('Y-m-d', strtotime('monday this week'));

        $jadwal_lalu = $this->get_jadwal_minggu($id_user, $senin_lalu, $minggu_lalu);
        $count = 0;
        foreach ($jadwal_lalu as $j) {
            $offset = (strtotime($j->tanggal) - strtotime($senin_lalu)) / 86400;
            $tanggal_baru = date('Y-m-d', strtotime($senin_ini . ' +' . $offset . ' days'));
            $this->simpan_jadwal([
                'id_user'     => $id_user,
                'tanggal'     => $tanggal_baru,
                'waktu_makan' => $j->waktu_makan,
                'id_resep'    => $j->id_resep,
                'nama_custom' => $j->nama_custom,
            ]);
            $count++;
        }
        return $count;
    }

    // ── DAFTAR BELANJA ───────────────────────────────
    public function generate_daftar_belanja($id_user, $id_budget, $tanggal_mulai, $tanggal_selesai)
    {
        // Hapus belanja lama untuk budget ini
        $this->db->where(['id_user' => $id_user, 'id_budget' => $id_budget])->delete('daftar_belanja');

        // Ambil jadwal minggu ini
        $jadwal = $this->get_jadwal_minggu($id_user, $tanggal_mulai, $tanggal_selesai);
        $bahan_aggregate = [];

        foreach ($jadwal as $j) {
            if (!$j->id_resep) continue;
            $bahan_list = $this->db->where('id_resep', $j->id_resep)
                ->get('bahan_resep')->result();
            foreach ($bahan_list as $b) {
                $key = strtolower($b->nama_bahan) . '|' . $b->satuan;
                if (!isset($bahan_aggregate[$key])) {
                    $bahan_aggregate[$key] = [
                        'nama_item'      => $b->nama_bahan,
                        'jumlah'         => 0,
                        'satuan'         => $b->satuan,
                        'estimasi_harga' => 0,
                    ];
                }
                $bahan_aggregate[$key]['jumlah'] += $b->jumlah;
                $bahan_aggregate[$key]['estimasi_harga'] += $b->harga_satuan;
            }
        }

        foreach ($bahan_aggregate as $item) {
            $item['id_user']   = $id_user;
            $item['id_budget'] = $id_budget;
            $this->db->insert('daftar_belanja', $item);
        }
        return count($bahan_aggregate);
    }

    public function get_daftar_belanja($id_user, $id_budget)
    {
        return $this->db->where(['id_user' => $id_user, 'id_budget' => $id_budget])
            ->order_by('is_checked, nama_item')
            ->get('daftar_belanja')->result();
    }

    public function toggle_belanja($id_belanja, $id_user)
    {
        $row = $this->db->get_where('daftar_belanja', ['id_belanja' => $id_belanja, 'id_user' => $id_user])->row();
        if ($row) {
            $this->db->where('id_belanja', $id_belanja)
                ->update('daftar_belanja', ['is_checked' => !$row->is_checked]);
        }
    }

    // ── PENGELUARAN ──────────────────────────────────
    public function get_pengeluaran_list($id_user, $id_budget)
    {
        return $this->db->where(['id_user' => $id_user, 'id_budget' => $id_budget])
            ->order_by('tanggal DESC, id_pengeluaran DESC')
            ->get('pengeluaran')->result();
    }

    public function simpan_pengeluaran($data)
    {
        $this->db->insert('pengeluaran', $data);
        return $this->db->insert_id();
    }

    public function hapus_pengeluaran($id_pengeluaran, $id_user)
    {
        $this->db->where(['id_pengeluaran' => $id_pengeluaran, 'id_user' => $id_user])
            ->delete('pengeluaran');
    }

    // ── LAPORAN ──────────────────────────────────────
    public function get_laporan_mingguan($id_user, $limit = 8)
    {
        $this->db->select('b.*, COALESCE(SUM(p.harga), 0) as total_belanja');
        $this->db->from('budget_minggu b');
        $this->db->join('pengeluaran p', 'p.id_budget = b.id_budget AND p.id_user = b.id_user', 'left');
        $this->db->where('b.id_user', $id_user);
        $this->db->group_by('b.id_budget, b.id_user, b.minggu_ke, b.tahun, b.tanggal_mulai, b.tanggal_selesai, b.budget_amount, b.created_at');
        $this->db->order_by('b.tahun DESC, b.minggu_ke DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Laporan mingguan filtered by bulan & tahun
     */
    public function get_laporan_by_bulan($id_user, $bulan, $tahun)
    {
        $sql = "SELECT b.*, COALESCE(SUM(p.harga), 0) as total_belanja
                FROM budget_minggu b
                LEFT JOIN pengeluaran p ON p.id_budget = b.id_budget AND p.id_user = b.id_user
                WHERE b.id_user = ?
                  AND (MONTH(b.tanggal_mulai) = ? OR MONTH(b.tanggal_selesai) = ?)
                  AND (YEAR(b.tanggal_mulai) = ? OR YEAR(b.tanggal_selesai) = ?)
                GROUP BY b.id_budget, b.id_user, b.minggu_ke, b.tahun, b.tanggal_mulai, b.tanggal_selesai, b.budget_amount, b.created_at
                ORDER BY b.tanggal_mulai ASC";
        return $this->db->query($sql, [$id_user, $bulan, $bulan, $tahun, $tahun])->result();
    }

    /**
     * Ringkasan bulanan: total budget, total belanja, per kategori
     */
    public function get_ringkasan_bulanan($id_user, $bulan, $tahun)
    {
        $tgl_awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));

        // Total pengeluaran bulan ini
        $sql_total = "SELECT COALESCE(SUM(harga), 0) as total, COUNT(*) as transaksi
                      FROM pengeluaran
                      WHERE id_user = ? AND tanggal >= ? AND tanggal <= ?";
        $total = $this->db->query($sql_total, [$id_user, $tgl_awal, $tgl_akhir])->row();

        // Per kategori
        $sql_kat = "SELECT kategori, COALESCE(SUM(harga), 0) as total, COUNT(*) as jumlah
                    FROM pengeluaran
                    WHERE id_user = ? AND tanggal >= ? AND tanggal <= ?
                    GROUP BY kategori ORDER BY total DESC";
        $per_kat = $this->db->query($sql_kat, [$id_user, $tgl_awal, $tgl_akhir])->result();

        // Total budget bulan ini
        $sql_budget = "SELECT COALESCE(SUM(budget_amount), 0) as total_budget
                       FROM budget_minggu
                       WHERE id_user = ?
                         AND tanggal_mulai >= ? AND tanggal_mulai <= ?";
        $budget = $this->db->query($sql_budget, [$id_user, $tgl_awal, $tgl_akhir])->row();

        // Per hari (untuk chart)
        $sql_daily = "SELECT tanggal, COALESCE(SUM(harga), 0) as total
                      FROM pengeluaran
                      WHERE id_user = ? AND tanggal >= ? AND tanggal <= ?
                      GROUP BY tanggal ORDER BY tanggal ASC";
        $per_hari = $this->db->query($sql_daily, [$id_user, $tgl_awal, $tgl_akhir])->result();

        return [
            'total'        => (float)($total->total ?? 0),
            'transaksi'    => (int)($total->transaksi ?? 0),
            'total_budget' => (float)($budget->total_budget ?? 0),
            'per_kategori' => $per_kat,
            'per_hari'     => $per_hari,
            'tgl_awal'     => $tgl_awal,
            'tgl_akhir'    => $tgl_akhir,
        ];
    }

    /**
     * Daftar bulan yang ada datanya
     */
    public function get_bulan_tersedia($id_user)
    {
        $sql = "SELECT DISTINCT YEAR(tanggal) as tahun,
                       MONTH(tanggal) as bulan
                FROM pengeluaran WHERE id_user = ?
                UNION
                SELECT DISTINCT tahun, MONTH(tanggal_mulai) as bulan
                FROM budget_minggu WHERE id_user = ?
                ORDER BY tahun DESC, bulan DESC";
        return $this->db->query($sql, [$id_user, $id_user])->result();
    }

    // ── FAVORIT ──────────────────────────────────────
    public function toggle_favorit($id_user, $id_resep)
    {
        $exists = $this->db->get_where('menu_favorit', [
            'id_user' => $id_user, 'id_resep' => $id_resep
        ])->row();
        if ($exists) {
            $this->db->where('id_favorit', $exists->id_favorit)->delete('menu_favorit');
            return false;
        } else {
            $this->db->insert('menu_favorit', ['id_user' => $id_user, 'id_resep' => $id_resep]);
            return true;
        }
    }

    public function get_favorit_ids($id_user)
    {
        $rows = $this->db->select('id_resep')->where('id_user', $id_user)->get('menu_favorit')->result();
        return array_column($rows, 'id_resep');
    }

    // ── MASTER HARGA ─────────────────────────────────
    public function get_all_harga($id_user, $kategori = null)
    {
        $this->db->where('id_user', $id_user);
        if ($kategori) $this->db->where('kategori_bahan', $kategori);
        $this->db->order_by('kategori_bahan, nama_bahan');
        return $this->db->get('master_harga')->result();
    }

    public function get_harga_by_id($id_harga)
    {
        return $this->db->get_where('master_harga', ['id_harga' => $id_harga])->row();
    }

    public function simpan_harga($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('master_harga', $data);
        return $this->db->insert_id();
    }

    public function update_harga($id_harga, $id_user, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where(['id_harga' => $id_harga, 'id_user' => $id_user])
            ->update('master_harga', $data);
    }

    public function hapus_harga($id_harga, $id_user)
    {
        $this->db->where(['id_harga' => $id_harga, 'id_user' => $id_user])
            ->delete('master_harga');
    }

    public function get_kategori_bahan($id_user)
    {
        $this->db->select('kategori_bahan, COUNT(*) as total');
        $this->db->where('id_user', $id_user);
        $this->db->where('kategori_bahan IS NOT NULL');
        $this->db->group_by('kategori_bahan');
        $this->db->order_by('kategori_bahan');
        return $this->db->get('master_harga')->result();
    }

    /**
     * Cari harga dari master berdasarkan nama bahan (untuk auto-fill di form resep)
     */
    public function cari_harga_bahan($id_user, $keyword)
    {
        $this->db->like('LOWER(nama_bahan)', strtolower($keyword));
        $this->db->where('id_user', $id_user);
        $this->db->order_by('nama_bahan');
        $this->db->limit(10);
        return $this->db->get('master_harga')->result();
    }

    // ── PEMASUKAN BULANAN ─────────────────────────────

    public function get_pemasukan_bulan($id_user, $bulan, $tahun)
    {
        $this->db->where(['id_user' => $id_user, 'bulan' => $bulan, 'tahun' => $tahun]);
        $this->db->order_by('tanggal ASC, id_pemasukan ASC');
        return $this->db->get('pemasukan')->result();
    }

    public function get_total_pemasukan_bulan($id_user, $bulan, $tahun)
    {
        $this->db->select_sum('jumlah');
        $this->db->where(['id_user' => $id_user, 'bulan' => $bulan, 'tahun' => $tahun]);
        $row = $this->db->get('pemasukan')->row();
        return $row ? (float)$row->jumlah : 0;
    }

    public function simpan_pemasukan($data)
    {
        $this->db->insert('pemasukan', $data);
        return $this->db->insert_id();
    }

    public function update_pemasukan($id, $id_user, $data)
    {
        $this->db->where(['id_pemasukan' => $id, 'id_user' => $id_user])->update('pemasukan', $data);
    }

    public function hapus_pemasukan($id, $id_user)
    {
        $this->db->where(['id_pemasukan' => $id, 'id_user' => $id_user])->delete('pemasukan');
    }

    public function get_ringkasan_saldo_bulanan($id_user, $bulan, $tahun)
    {
        $tgl_awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));

        // Total pemasukan
        $total_pemasukan = $this->get_total_pemasukan_bulan($id_user, $bulan, $tahun);

        // Total pengeluaran dapur (dari tabel pengeluaran)
        $sql_dapur = "SELECT COALESCE(SUM(harga), 0) as total FROM pengeluaran
                      WHERE id_user = ? AND tanggal >= ? AND tanggal <= ?";
        $dapur = $this->db->query($sql_dapur, [$id_user, $tgl_awal, $tgl_akhir])->row();
        $total_dapur = (float)($dapur->total ?? 0);

        // Total belanja (dari tabel daftar_belanja, yang sudah dibeli)
        $sql_belanja = "SELECT COALESCE(SUM(estimasi_harga), 0) as total FROM daftar_belanja
                WHERE id_user = ?
                AND created_at >= ? AND created_at <= CONCAT(?, ' 23:59:59')";
        $belanja = $this->db->query($sql_belanja, [$id_user, $tgl_awal, $tgl_akhir])->row();
        $total_belanja = (float)($belanja->total ?? 0);

        // Total pengeluaran lain (listrik, BPJS, dll)
        $sql_lain = "SELECT COALESCE(SUM(jumlah), 0) as total FROM pengeluaran_lain
                     WHERE id_user = ? AND tanggal >= ? AND tanggal <= ?";
        $lain = $this->db->query($sql_lain, [$id_user, $tgl_awal, $tgl_akhir])->row();
        $total_lain = (float)($lain->total ?? 0);

        // Pemasukan per sumber
        $sql_per_sumber = "SELECT sumber, SUM(jumlah) as total, COUNT(*) as kali
                           FROM pemasukan WHERE id_user = ? AND bulan = ? AND tahun = ?
                           GROUP BY sumber ORDER BY total DESC";
        $per_sumber = $this->db->query($sql_per_sumber, [$id_user, $bulan, $tahun])->result();

        // Pengeluaran lain per kategori
        $sql_lain_kat = "SELECT kategori, SUM(jumlah) as total, COUNT(*) as jumlah
                         FROM pengeluaran_lain
                         WHERE id_user = ? AND tanggal >= ? AND tanggal <= ?
                         GROUP BY kategori ORDER BY total DESC";
        $lain_per_kat = $this->db->query($sql_lain_kat, [$id_user, $tgl_awal, $tgl_akhir])->result();

        $total_keluar = $total_dapur + $total_belanja + $total_lain;
        $saldo = $total_pemasukan - $total_keluar;

        return [
            'total_pemasukan' => $total_pemasukan,
            'total_dapur'     => $total_dapur,
            'total_belanja'   => $total_belanja,
            'total_lain'      => $total_lain,
            'total_keluar'    => $total_keluar,
            'saldo'           => $saldo,
            'per_sumber'      => $per_sumber,
            'lain_per_kat'    => $lain_per_kat,
        ];
    }

    // ── PENGELUARAN LAIN ──────────────────────────────

    public function get_pengeluaran_lain_bulan($id_user, $bulan, $tahun)
    {
        $tgl_awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
        $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));
        $this->db->where('id_user', $id_user);
        $this->db->where('tanggal >=', $tgl_awal);
        $this->db->where('tanggal <=', $tgl_akhir);
        $this->db->order_by('tanggal DESC, id_pengeluaran_lain DESC');
        return $this->db->get('pengeluaran_lain')->result();
    }

    public function simpan_pengeluaran_lain($data)
    {
        $this->db->insert('pengeluaran_lain', $data);
        return $this->db->insert_id();
    }

    public function hapus_pengeluaran_lain($id, $id_user)
    {
        $this->db->where(['id_pengeluaran_lain' => $id, 'id_user' => $id_user])->delete('pengeluaran_lain');
    }

    // ══════════════════════════════════════════════════
    // FITUR 1: HOME RINGKASAN - Tren 3 bulan
    // ══════════════════════════════════════════════════

    public function get_tren_3bulan($id_user)
    {
        $result = [];
        for ($i = 2; $i >= 0; $i--) {
            $dt = strtotime("-{$i} months");
            $bln = (int)date('m', $dt);
            $thn = (int)date('Y', $dt);
            $tgl_awal = sprintf('%04d-%02d-01', $thn, $bln);
            $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));

            // Pengeluaran dapur
            $dapur = $this->db->query("SELECT COALESCE(SUM(p.harga),0) as total FROM pengeluaran p JOIN budget_minggu b ON p.id_budget=b.id_budget WHERE p.id_user=? AND p.tanggal>=? AND p.tanggal<=?", [$id_user, $tgl_awal, $tgl_akhir])->row()->total;

            // Belanja
            $belanja = $this->db->query("SELECT COALESCE(SUM(estimasi_harga),0) as total FROM daftar_belanja WHERE id_user=? AND created_at>=? AND created_at<=?", [$id_user, $tgl_awal, $tgl_akhir . ' 23:59:59'])->row()->total;

            // Pengeluaran lain
            $lain = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as total FROM pengeluaran_lain WHERE id_user=? AND tanggal>=? AND tanggal<=?", [$id_user, $tgl_awal, $tgl_akhir])->row()->total;

            // Pemasukan
            $masuk = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as total FROM pemasukan WHERE id_user=? AND bulan=? AND tahun=?", [$id_user, $bln, $thn])->row()->total;

            $result[] = (object)[
                'bulan' => $bln, 'tahun' => $thn,
                'dapur' => (float)$dapur, 'belanja' => (float)$belanja,
                'lain' => (float)$lain, 'pemasukan' => (float)$masuk,
                'total_keluar' => (float)$dapur + (float)$belanja + (float)$lain,
            ];
        }
        return $result;
    }

    public function get_budget_alerts($id_user)
    {
        $alerts = [];
        // Budget dapur minggu ini
        $budget = $this->get_budget_minggu_ini($id_user);
        if ($budget && $budget->id_budget) {
            $terpakai = $this->get_total_pengeluaran_minggu($id_user, $budget->id_budget);
            $pct = (float)$budget->budget_amount > 0 ? ($terpakai / (float)$budget->budget_amount * 100) : 0;
            if ($pct >= 80) $alerts[] = (object)['type' => 'dapur', 'pct' => round($pct), 'msg' => 'Budget dapur minggu ini sudah ' . round($pct) . '% terpakai!'];
        }
        // Budget belanja bulan ini
        $bln = (int)date('m');
        $thn = (int)date('Y');
        $bb = $this->get_budget_bulanan($id_user, $bln, $thn);
        if ($bb) {
            $items = $this->get_daftar_belanja_bulan($id_user, $bln, $thn);
            $total_bel = array_sum(array_map(fn ($i) => (float)$i->estimasi_harga, $items));
            $pct_bel = (float)$bb->budget_belanja > 0 ? ($total_bel / (float)$bb->budget_belanja * 100) : 0;
            if ($pct_bel >= 80) $alerts[] = (object)['type' => 'belanja', 'pct' => round($pct_bel), 'msg' => 'Budget belanja bulan ini sudah ' . round($pct_bel) . '% terpakai!'];

            $pl = $this->get_pengeluaran_lain_bulan($id_user, $bln, $thn);
            $total_lain = array_sum(array_map(fn ($p) => (float)$p->jumlah, $pl));
            $pct_lain = (float)$bb->budget_lainnya > 0 ? ($total_lain / (float)$bb->budget_lainnya * 100) : 0;
            if ($pct_lain >= 80) $alerts[] = (object)['type' => 'lain', 'pct' => round($pct_lain), 'msg' => 'Budget pengeluaran lain sudah ' . round($pct_lain) . '% terpakai!'];
        }
        return $alerts;
    }

    // ══════════════════════════════════════════════════
    // FITUR 2: Auto-Generate Pengeluaran Rutin
    // ══════════════════════════════════════════════════

    public function auto_generate_rutin($id_user, $bulan, $tahun)
    {
        // Get last month's rutin items
        $pm = $bulan - 1;
        $py = $tahun;
        if ($pm < 1) {
            $pm = 12;
            $py--;
        }

        $rutin_items = $this->db->where([
            'id_user' => $id_user, 'is_rutin' => 1,
        ])->where('MONTH(tanggal)', $pm)->where('YEAR(tanggal)', $py)
            ->get('pengeluaran_lain')->result();

        // Check if already generated this month
        $existing = $this->db->where([
            'id_user' => $id_user, 'is_rutin' => 1,
        ])->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)
            ->count_all_results('pengeluaran_lain');

        if ($existing > 0 || empty($rutin_items)) return 0;

        $count = 0;
        foreach ($rutin_items as $item) {
            $tgl_baru = sprintf('%04d-%02d-%02d', $tahun, $bulan, min((int)date('d', strtotime($item->tanggal)), (int)date('t', mktime(0, 0, 0, $bulan, 1, $tahun))));
            $this->db->insert('pengeluaran_lain', [
                'id_user'  => $id_user,
                'nama'     => $item->nama,
                'jumlah'   => $item->jumlah,
                'kategori' => $item->kategori,
                'tanggal'  => $tgl_baru,
                'catatan'  => $item->catatan,
                'is_rutin' => 1,
            ]);
            $count++;
        }
        return $count;
    }

    // ══════════════════════════════════════════════════
    // FITUR 4: Catatan Minggu
    // ══════════════════════════════════════════════════

    public function get_catatan_minggu($id_user, $minggu_ke, $tahun)
    {
        return $this->db->get_where('catatan_minggu', [
            'id_user' => $id_user, 'minggu_ke' => $minggu_ke, 'tahun' => $tahun
        ])->row();
    }

    public function save_catatan_minggu($id_user, $minggu_ke, $tahun, $catatan)
    {
        $existing = $this->get_catatan_minggu($id_user, $minggu_ke, $tahun);
        if ($existing) {
            $this->db->where('id', $existing->id)->update('catatan_minggu', ['catatan' => $catatan]);
        } else {
            $this->db->insert('catatan_minggu', [
                'id_user' => $id_user, 'minggu_ke' => $minggu_ke, 'tahun' => $tahun, 'catatan' => $catatan,
            ]);
        }
    }

    // ══════════════════════════════════════════════════
    // FITUR 5: Template Belanja
    // ══════════════════════════════════════════════════

    public function get_templates($id_user)
    {
        return $this->db->where('id_user', $id_user)->order_by('created_at DESC')->get('template_belanja')->result();
    }

    public function get_template_items($id_template)
    {
        return $this->db->where('id_template', $id_template)->get('template_belanja_item')->result();
    }

    public function save_template($id_user, $nama, $items)
    {
        $this->db->insert('template_belanja', ['id_user' => $id_user, 'nama_template' => $nama]);
        $id_tpl = $this->db->insert_id();
        foreach ($items as $item) {
            $item['id_template'] = $id_tpl;
            $this->db->insert('template_belanja_item', $item);
        }
        return $id_tpl;
    }

    public function apply_template($id_user, $id_template)
    {
        $items = $this->get_template_items($id_template);
        $count = 0;
        foreach ($items as $it) {
            $this->db->insert('daftar_belanja', [
                'id_user' => $id_user,
                'nama_item' => $it->nama_item,
                'jumlah' => $it->jumlah,
                'satuan' => $it->satuan,
                'estimasi_harga' => $it->estimasi_harga,
                'kategori_item' => $it->kategori_item,
            ]);
            $count++;
        }
        return $count;
    }

    public function delete_template($id_template, $id_user)
    {
        $tpl = $this->db->get_where('template_belanja', ['id' => $id_template, 'id_user' => $id_user])->row();
        if (!$tpl) return;
        $this->db->where('id_template', $id_template)->delete('template_belanja_item');
        $this->db->where('id', $id_template)->delete('template_belanja');
    }

    // ══════════════════════════════════════════════════
    // FITUR 7: Target Tabungan
    // ══════════════════════════════════════════════════

    public function get_tabungan($id_user)
    {
        return $this->db->where(['id_user' => $id_user, 'is_active' => 1])->order_by('created_at DESC')->get('target_tabungan')->result();
    }

    public function get_total_sisa_bulanan($id_user)
    {
        // Sum of (pemasukan - total pengeluaran) per month, for all months with data
        $rows = $this->db->query("
            SELECT p.bulan, p.tahun, p.jumlah as pemasukan
            FROM pemasukan p WHERE p.id_user = ?
            ORDER BY p.tahun DESC, p.bulan DESC
        ", [$id_user])->result();

        $total_sisa = 0;
        $months_done = [];
        foreach ($rows as $r) {
            $key = $r->tahun . '-' . $r->bulan;
            if (isset($months_done[$key])) {
                $months_done[$key] += (float)$r->pemasukan;
                continue;
            }
            $months_done[$key] = (float)$r->pemasukan;
        }

        foreach ($months_done as $key => $pemasukan) {
            list($thn, $bln) = explode('-', $key);
            $saldo = $this->get_ringkasan_saldo_bulanan($id_user, (int)$bln, (int)$thn);
            $total_sisa += $saldo['saldo'];
        }
        return $total_sisa;
    }

    public function save_tabungan($id_user, $nama, $target)
    {
        $this->db->insert('target_tabungan', [
            'id_user' => $id_user, 'nama_target' => $nama, 'target_amount' => $target,
        ]);
        return $this->db->insert_id();
    }

    public function delete_tabungan($id, $id_user)
    {
        $this->db->where(['id' => $id, 'id_user' => $id_user])->update('target_tabungan', ['is_active' => 0]);
    }
}

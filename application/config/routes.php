<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING - MealPlan Rumah
| -------------------------------------------------------------------------
|
| URL Akses:
|   http://localhost/mealplan/
|   http://localhost/mealplan/dashboard
|   http://localhost/mealplan/setup
|   http://localhost/mealplan/jadwal
|   http://localhost/mealplan/resep
|   http://localhost/mealplan/belanja
|   http://localhost/mealplan/pengeluaran
|   http://localhost/mealplan/laporan
|
*/

// Default controller → splash page
$route['default_controller'] = 'C_auth/welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ── Auth ─────────────────────────────────────────
$route['welcome']             = 'C_auth/welcome';
$route['login']               = 'C_auth/login';
$route['auth/login']          = 'C_auth/do_login';
$route['register']            = 'C_auth/register';
$route['auth/register']       = 'C_auth/do_register';
$route['logout']              = 'C_auth/logout';

// ── Halaman utama (Home = Laporan Saldo) ─────────
$route['dashboard']           = 'C_mealplan/index';
$route['laporan']             = 'C_mealplan/laporan';
$route['dapur']               = 'C_mealplan/dapur';
$route['dapur/update-budget'] = 'C_mealplan/update_budget_dapur';

// ── Setup ────────────────────────────────────────
$route['setup']               = 'C_mealplan/setup';
$route['setup/save']          = 'C_mealplan/save_settings';

// ── Jadwal Menu ──────────────────────────────────
$route['jadwal']              = 'C_mealplan/jadwal';
$route['jadwal/simpan']       = 'C_mealplan/simpan_jadwal';
$route['jadwal/hapus']        = 'C_mealplan/hapus_jadwal';
$route['jadwal/debug']        = 'C_mealplan/debug_jadwal';
$route['jadwal/debug']        = 'C_mealplan/debug_jadwal';
$route['jadwal/copy']         = 'C_mealplan/copy_minggu_lalu';
$route['jadwal/rekomendasi']  = 'C_mealplan/rekomendasi_menu';
$route['jadwal/apply']        = 'C_mealplan/apply_rekomendasi';

// ── Database Resep ───────────────────────────────
$route['resep']               = 'C_mealplan/resep';
$route['resep/detail/(:num)'] = 'C_mealplan/resep_detail/$1';
$route['resep/simpan']        = 'C_mealplan/simpan_resep';
$route['resep/update']        = 'C_mealplan/update_resep';
$route['resep/hapus']         = 'C_mealplan/hapus_resep';
$route['resep/favorit']       = 'C_mealplan/toggle_favorit';

// ── Daftar Belanja ───────────────────────────────
$route['belanja']             = 'C_mealplan/belanja';
$route['belanja/generate']    = 'C_mealplan/generate_belanja';
$route['belanja/toggle']      = 'C_mealplan/toggle_belanja';
$route['belanja/tambah']      = 'C_mealplan/tambah_belanja';
$route['belanja/hapus']       = 'C_mealplan/hapus_belanja';
$route['belanja/update']      = 'C_mealplan/update_belanja';
$route['belanja/update-budget'] = 'C_mealplan/update_budget_bulanan';

// ── Pengeluaran ──────────────────────────────────
$route['pengeluaran']         = 'C_mealplan/pengeluaran';
$route['pengeluaran/simpan']  = 'C_mealplan/simpan_pengeluaran';
$route['pengeluaran/hapus']   = 'C_mealplan/hapus_pengeluaran';
$route['pengeluaran/update']  = 'C_mealplan/update_pengeluaran';

// ── Master Harga ─────────────────────────────
$route['master-harga']           = 'C_mealplan/master_harga';
$route['master-harga/simpan']    = 'C_mealplan/simpan_harga';
$route['master-harga/update']    = 'C_mealplan/update_harga';
$route['master-harga/hapus']     = 'C_mealplan/hapus_harga';
$route['master-harga/search']    = 'C_mealplan/search_harga';

// ── Rencana Makan ────────────────────────────
$route['rencana']                = 'C_mealplan/rencana_makan';

// ── Pemasukan Bulanan ────────────────────────────
$route['pemasukan']              = 'C_mealplan/pemasukan';
$route['pemasukan/simpan']       = 'C_mealplan/simpan_pemasukan_bulanan';
$route['pemasukan/hapus']        = 'C_mealplan/hapus_pemasukan_bulanan';

// ── Pengeluaran Lain ─────────────────────────────
$route['pengeluaran-lain/simpan'] = 'C_mealplan/simpan_pengeluaran_lain';
$route['pengeluaran-lain/hapus']  = 'C_mealplan/hapus_pengeluaran_lain';
$route['pengeluaran-lain/update'] = 'C_mealplan/update_pengeluaran_lain';

// ── Fitur 3: Export ──────────────────────────────
$route['export-laporan']          = 'C_mealplan/export_laporan';

// ── Fitur 4: Catatan Minggu ─────────────────────
$route['dapur/save-catatan']      = 'C_mealplan/save_catatan';

// ── Fitur 5: Template Belanja ───────────────────
$route['template/save']           = 'C_mealplan/save_template';
$route['template/apply']          = 'C_mealplan/apply_template';
$route['template/delete']         = 'C_mealplan/delete_template';

// ── Fitur 7: Tabungan ──────────────────────────
$route['tabungan/save']           = 'C_mealplan/save_tabungan';
$route['tabungan/delete']         = 'C_mealplan/delete_tabungan';

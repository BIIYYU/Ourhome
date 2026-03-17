<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_mealplan', 'model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    /**
     * Splash / Welcome page
     */
    public function welcome() {
        // Sudah login → langsung ke dashboard
        if ($this->session->userdata('id_user')) {
            redirect('dashboard');
            return;
        }
        $this->load->view('auth/welcome');
    }

    /**
     * Login page
     */
    public function login() {
        if ($this->session->userdata('id_user')) {
            redirect('dashboard');
            return;
        }

        $data = ['error' => $this->session->flashdata('error')];
        $this->load->view('auth/login', $data);
    }

    /**
     * Process login
     */
    public function do_login() {
        $email    = trim($this->input->post('email'));
        $password = $this->input->post('password');

        if (!$email || !$password) {
            $this->session->set_flashdata('error', 'Email dan password harus diisi.');
            redirect('login');
            return;
        }

        $user = $this->db->get_where('users', ['email' => $email])->row();

        if (!$user || !password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Email atau password salah.');
            redirect('login');
            return;
        }

        // Set session
        $this->session->set_userdata([
            'id_user'   => $user->id_user,
            'nama_user' => $user->nama,
            'email'     => $user->email,
            'logged_in' => true,
        ]);

        redirect('dashboard');
    }

    /**
     * Register page
     */
    public function register() {
        if ($this->session->userdata('id_user')) {
            redirect('dashboard');
            return;
        }

        $data = ['error' => $this->session->flashdata('error')];
        $this->load->view('auth/register', $data);
    }

    /**
     * Process register
     */
    public function do_register() {
        $nama     = trim($this->input->post('nama'));
        $email    = trim($this->input->post('email'));
        $password = $this->input->post('password');
        $confirm  = $this->input->post('confirm');

        // Validasi
        if (!$nama || !$email || !$password) {
            $this->session->set_flashdata('error', 'Semua field harus diisi.');
            redirect('register');
            return;
        }

        if ($password !== $confirm) {
            $this->session->set_flashdata('error', 'Password tidak cocok.');
            redirect('register');
            return;
        }

        if (strlen($password) < 6) {
            $this->session->set_flashdata('error', 'Password minimal 6 karakter.');
            redirect('register');
            return;
        }

        // Cek email sudah terdaftar
        $exists = $this->db->get_where('users', ['email' => $email])->row();
        if ($exists) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar. Silakan login.');
            redirect('register');
            return;
        }

        // Insert user
        $this->db->insert('users', [
            'nama'     => $nama,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        $id_user = $this->db->insert_id();

        // Auto create settings
        $this->db->insert('user_settings', [
            'id_user'         => $id_user,
            'jumlah_orang'    => 2,
            'frekuensi_makan' => 3,
            'budget_mingguan' => 300000,
        ]);

        // Auto login
        $this->session->set_userdata([
            'id_user'   => $id_user,
            'nama_user' => $nama,
            'email'     => $email,
            'logged_in' => true,
        ]);

        $this->session->set_flashdata('success', 'Selamat datang, ' . $nama . '! 🎉');
        redirect('setup');
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('welcome');
    }
}

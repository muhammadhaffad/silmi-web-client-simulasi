<?php
class Login extends Controller {
    public function index() {
        $this->view('templates/header');
        $this->view('login/index');
        $this->view('templates/footer');
    }
    public function auth() {
        $pelanggan = $this->model('Auth_model')->auth($_POST);
        if (!empty($pelanggan)) {
            $_SESSION['idpelanggan'] = $pelanggan['idpelanggan'];
            $_SESSION['namapelanggan'] = $pelanggan['namapelanggan'];
            Flasher::setFlash('Login berhasil!', '', 'success');
            header('Location: '.BASEURL.'/produk');
            exit;
        } else {
            Flasher::setFlash('Login gagal!', '', 'danger');
            header('Location: '.BASEURL.'/login');
            exit;
        }
    }
    public function logout() {
        unset($_SESSION['idpelanggan']);
        unset($_SESSION['namapelanggan']);
        Flasher::setFlash('Logout berhasil!', '', 'success');
        header('Location: '.BASEURL.'/produk');
    }
}
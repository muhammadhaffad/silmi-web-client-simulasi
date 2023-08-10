<?php
class Login extends Controller {
    public function index() {
        $this->view('templates/header');
        $this->view('login/index');
        $this->view('templates/footer');
    }
    public function auth() {
        $idpelanggan = $this->model('Auth_model')->auth($_POST);
        if (!empty($idpelanggan)) {
            $_SESSION['idpelanggan'] = $idpelanggan['idpelanggan'];
            Flasher::setFlash('Login berhasil!', '', 'success');
            header('Location: '.BASEURL.'/produk');
            exit;
        } else {
            Flasher::setFlash('Login gagal!', '', 'danger');
            header('Location: '.BASEURL.'/login');
            exit;
        }
    }
}
<?php
class Keranjang extends Controller {
    public function __construct()
    {
        /* Jika belum login, tapi tambah keranjang */
        $idPelanggan = $_SESSION['idpelanggan'];
        if ($idPelanggan == 1) {
            Flasher::setFlash('Keranjang gagal ditambah, silahkan login terlebih dahulu', '', 'danger');
            header('Location: '.BASEURL.'/produk');
            exit;
        }
    }
    public function index() {
        $produk = $this->model('Keranjang_model')->getKeranjangPelanggan();
        $produk = $this->cleanKeys($this->groupBarang($produk));
        $data['produk'] = $produk;
        $this->view('templates/header');
        $this->view('templates/nav');
        $this->view('keranjang/index', $data);
        $this->view('templates/footer');
    }
    public function tambah() {
        /* Request API Cek Stok */
        $barang = $this->model('Produk_model')->getBarangItem($_POST['idmodelbarang'], $_POST['produk_item']);
        $data = ['produk' => array_map(function ($item) {
            return [
                'kode_produk' => $item['kodebarang'],
                'jumlah' => (int)($_POST['jumlah'])
            ];
        }, $barang)];
        $data = json_encode($data);
        list($status, $response) = Helper::httpRequestJson('http://localhost/silmi/api/v1/cekstok', $data);
        $response = json_decode($response);

        /* Update stok sesuai data dari API */
        $success = 0;
        foreach($response->data as $produk) {
            $rowCount = $this->model('Produk_model')->updateStok($produk->kode_produk, $produk->stok);
            if ($rowCount > 0) {
                $success += 1;
            }
        }

        /* Redirect ke produk jika error */
        if ($status === 422) {
            Flasher::setFlash($response->message, '', 'danger');
            header('Location: '.BASEURL.'/produk');
            exit;
        }

        /* Cek stok */
        $stokBarang = array_column($barang, 'stokbarangitem');
        foreach($stokBarang as $stok) {
            if (!isset($_temp[$stok])) {
                $_temp[$stok] = $stok;
                if ($stok < $_POST['jumlah']) {
                    Flasher::setFlash('Produk gagal dimasukkan ke keranjang, stok tidak mencukupi', '', 'danger');
                    header('Location: '.BASEURL.'/produk');
                    exit;
                }
            }
        }

        /* Jika produk yang dipesan sudah ada di keranjang */
        $row = $this->model('Keranjang_model')->isExistItemKeranjang($_POST['produk_item']);
        if ($row > 0) {
            Flasher::setFlash('Produk sudah ada di keranjang', '', 'warning');
            header('Location: '.BASEURL.'/keranjang');
            exit;
        }

        /* Memasukkan produk item ke keranjang */
        $row = $this->model('Keranjang_model')->insertKeranjang([
            'jumlah' => $_POST['jumlah'],
            'idmodelbarangitem' => $_POST['produk_item']
        ]);
        if ($row > 0) {
            /* Jika sukses */
            Flasher::setFlash('Produk berhasil dimasukkan ke keranjang', '', 'success');
            header('Location: '.BASEURL.'/produk');
            exit;
        } else {
            /* Jika gagal masuk keranjang */
            Flasher::setFlash('Produk gagal dimasukkan ke keranjang', 'ditambahkan', 'danger');
            header('Location: '.BASEURL.'/produk');
            exit;
        }
    }
    public function tambah_jumlah($idkeranjang) {
        if ($this->model('Keranjang_model')->tambahJumlah($idkeranjang) > 0) {
            Flasher::setFlash('Jumlah item berhasil ditambah', '', 'success');
            header('Location: '.BASEURL.'/keranjang');
            exit;
        } else {
            Flasher::setFlash('Jumlah item gagal ditambah', '', 'danger');
            header('Location: '.BASEURL.'/keranjang');
            exit;
        }
    }
    public function kurang_jumlah($idkeranjang) {
        if ($this->model('Keranjang_model')->kurangJumlah($idkeranjang) > 0) {
            Flasher::setFlash('Jumlah item berhasil dikurangi', '', 'success');
            header('Location: '.BASEURL.'/keranjang');
            exit;
        } else {
            Flasher::setFlash('Jumlah item gagal dikurangi', '', 'danger');
            header('Location: '.BASEURL.'/keranjang');
            exit;
        }
    }
    public function hapus_item($idkeranjang) {
        if ($this->model('Keranjang_model')->deleteItemKeranjang($idkeranjang) > 0) {
            Flasher::setFlash('Item berhasil dihapus', '', 'success');
            header('Location: '.BASEURL.'/keranjang');
            exit;
        } else {
            Flasher::setFlash('Item gagal dihapus', '', 'danger');
            header('Location: '.BASEURL.'/keranjang');
            exit;
        }
    }
    private function cleanKeys(&$array) {
        $array = array_values($array);
        
        foreach ($array as $key => &$value) {
            foreach ($value as $k => &$v) {
                if (is_array($v)) {
                    $this->cleanKeys($v);
                }
            }
        }
        return $array;
    }
    private function groupBarang($produk) {
        foreach ($produk as $produkItem) {
            /* $groupKey = implode('_', array($produkItem['idpelanggan'], $produkItem['idmodelbarang'], $produkItem['namamodel'], $produkItem['deskripsi'])); */
            $groupKey = $produkItem['idmodelbarang'];
            if (!isset($dataGrouped[$groupKey])) {
                $dataGrouped[$groupKey] = [
                    'idpelanggan' => $produkItem['idpelanggan'],
                    'idmodelbarang' => $produkItem['idmodelbarang'],
                    'namamodel' => $produkItem['namamodel'],
                    'deskripsi' => $produkItem['deskripsi']
                ];
            }
            $subGroupKey = $produkItem['idmodelbarangitem'];
            if (!isset($dataGrouped[$groupKey]['items'][$subGroupKey])) {
                $dataGrouped[$groupKey]['items'][$subGroupKey] = [
                    'idkeranjang' => $produkItem['idkeranjang'],
                    'idmodelbarangitem' => $produkItem['idmodelbarangitem'],
                    'keteranganbarangitem' => $produkItem['keteranganbarangitem'],
                    'hargabarangitem' => $produkItem['hargabarangitem'],
                    'stokbarangitem' => $produkItem['stokbarangitem'],
                    'diskonbarangitem' => $produkItem['diskonbarangitem'],
                    'ukuranbarangitem' => $produkItem['ukuranbarangitem'],
                    'jumlah' => $produkItem['jumlah'],
                    'totalbarangitem' => $produkItem['totalbarangitem']
                ];
            };
            $dataGrouped[$groupKey]['items'][$subGroupKey]['barang'][] = [
                'kodebarang' => $produkItem['kodebarang'],
                'keterangan' => $produkItem['keterangan'],
                'kodewarna' => $produkItem['kodewarna'],
                'kodesize' => $produkItem['kodesize'],
                'idkelompok' => $produkItem['idkelompok'],
                'idunit' => $produkItem['idunit'],
                'stok' => $produkItem['stok'],
                'harga' => $produkItem['harga'],
                'jenis' => $produkItem['jenis'],
                'imglink' => $produkItem['imglink'],
                'berat' => $produkItem['berat']
            ];
        }
        return $dataGrouped;
    }
}
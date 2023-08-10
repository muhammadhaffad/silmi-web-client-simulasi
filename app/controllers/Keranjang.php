<?php
class Keranjang extends Controller {
    public function index() {
        $produk = $this->model('Keranjang_model')->getKeranjangPelanggan();
        $produk = $this->cleanKeys($this->groupBarang($produk));
        $data['produk'] = $produk;
        echo json_encode($produk);
        $this->view('templates/header');
        $this->view('templates/nav');
        $this->view('keranjang/index', $data);
        $this->view('templates/footer');
    }
    public function tambah() {
        $idPelanggan = $_SESSION['idpelanggan'];
        $barang = $this->model('Produk_model')->getBarangItem($_POST['idmodelbarang'], $_POST['produk_item']);
        $stokBarang = array_column($barang, 'stokbarangitem');
        if ($idPelanggan == 1) {
            Flasher::setFlash('Keranjang gagal ditambah, silahkan login terlebih dahulu', '', 'danger');
            header('Location: '.BASEURL.'/produk');
            exit;
        }
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
        $row = $this->model('Keranjang_model')->insertKeranjang([
            'jumlah' => $_POST['jumlah'],
            'idmodelbarangitem' => $_POST['produk_item']
        ]);
        if ($row > 0) {
            Flasher::setFlash('Produk berhasil dimasukkan ke keranjang', '', 'success');
            header('Location: '.BASEURL.'/produk');
            exit;
        } else {
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
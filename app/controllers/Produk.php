<?php

class Produk extends Controller {
    public function index() {
        $produk = $this->model('Produk_model')->getSemuaBarang();
        $produk = $this->groupBarang($produk);
        $data['produk'] = $this->cleanKeys($produk);
        $this->view('templates/header');
        $this->view('templates/nav');
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
    public function detail($idproduk) {
        $ukuran = (!empty($_GET['ukuran']) and isset($_GET['ukuran'])) ? $_GET['ukuran'] : null;
        $warna = (!empty($_GET['warna']) and isset($_GET['warna'])) ? $_GET['warna'] : null;
        $produk = $this->model('Produk_model')->getBarang($idproduk, $ukuran, $warna);
        $produk = $this->groupBarang($produk);
        $data['produk'] = $this->cleanKeys($produk)[0];
        echo json_encode($data['produk']);
        $this->view('templates/header');
        $this->view('templates/nav');
        $this->view('produk/detail', $data);
        $this->view('templates/footer');
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
                    'idmodelbarangitem' => $produkItem['idmodelbarangitem'],
                    'keteranganbarangitem' => $produkItem['keteranganbarangitem'],
                    'hargabarangitem' => $produkItem['hargabarangitem'],
                    'stokbarangitem' => $produkItem['stokbarangitem'],
                    'diskonbarangitem' => $produkItem['diskonbarangitem'],
                    'ukuranbarangitem' => $produkItem['ukuranbarangitem']
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
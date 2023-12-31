<?php
class Order extends Controller
{
    public function index()
    {
        $this->view('templates/header');
        $this->view('templates/nav');
        $this->view('order/informasi');
        $this->view('templates/footer');
    }
    public function informasi($idorder = null)
    {
        if ($idorder !== null) {
            $order = $this->model('Order_model')->getOrderPelanggan($idorder);
            $data['order'] = $order;
        }
        $produk = $this->model('Keranjang_model')->getKeranjangPelanggan();
        $produk = $this->cleanKeys($this->groupBarang($produk));
        $data['produk'] = $produk;
        $this->view('templates/header');
        $this->view('templates/nav');
        $this->view('order/informasi', $data);
        $this->view('templates/footer');
    }
    public function simpan_informasi($idorder = null)
    {
        if ($idorder !== null) {
            //TODO
        } else {
            $order = $this->model('Order_model')->createOrder($_POST);
        }
        if (!empty($order)) {
            Flasher::setFlash('Informasi berhasil disimpan', '', 'success');
            header('Location: ' . BASEURL . '/order/rincian/' . $order['idorder']);
            exit;
        } else {
        }
    }
    public function rincian($idorder)
    {
        if (empty($idorder)) {
            header('Location: ' . BASEURL . '/order/informasi');
            exit;
        }
        $order = $this->model('Order_model')->getOrderPelanggan($idorder, 0);
        if (empty($order)) {
            header('Location: ' . BASEURL . '/order/informasi');
            exit;
        }
        $data['order'] = $this->groupOrder($order);
        $produk = $this->model('Keranjang_model')->getKeranjangPelanggan();
        $produk = $this->cleanKeys($this->groupBarang($produk));
        $data['produk'] = $produk;
        $this->view('templates/header');
        $this->view('templates/nav');
        $this->view('order/pesan', $data);
        $this->view('templates/footer');
    }
    public function pesan_order($idorder)
    {
        $itemKeranjang = $this->model('Keranjang_model')->getKeranjangPelanggan();
        $data = ['produk' => array_map(function ($item) {
            return [
                'kode_produk' => $item['kodebarang'],
                'jumlah' => $item['jumlah']
            ];
        }, $itemKeranjang)];
        $data = json_encode($data);
        list($status, $response) = Helper::httpRequestJson('http://localhost/silmi/api/v1/cekstok', $data);
        $response = json_decode($response);
        $success = 0;
        foreach ($response->data as $produk) {
            $rowCount = $this->model('Produk_model')->updateStok($produk->kode_produk, $produk->stok);
            if ($rowCount > 0) {
                $success += 1;
            }
        }
        if ($status === 422) {
            Flasher::setFlash($response->message, '', 'danger');
            header('Location: ' . BASEURL . '/produk');
            exit;
        }
        /* get data order */
        $order = $this->model('Order_model')->getOrderPelanggan($idorder, 0);
        if (empty($order)) {
            header('Location: ' . BASEURL . '/order/informasi');
            exit;
        }
        $order = $this->groupOrder($order);
        /* contoh biaya ongkir */
        $ongkir = [
            1 => 5000
        ];
        $data = [
            'id_unit' => 'pst',
            'pengirim' => 'Nama toko distributor',
            'nama_pelanggan' => $order['namacustomer'],
            'alamat' => $order['alamat'],
            'keterangan' => '-',
            'id_ekspedisi' =>  (int)$_POST['id_kurir'],
            'biaya_ongkir_db' =>  $ongkir[$_POST['id_kurir']],
            'no_tlp' => $order['notlp'],
            'produk_detail' => array_map(function ($item) {
                return [
                    'kode_produk' => $item['kodebarang'],
                    'jumlah' => $item['jumlah']
                ];
            }, $itemKeranjang)
        ];
        $data = json_encode($data);
        list($status, $response) = Helper::httpRequestJson('http://localhost/silmi/api/v1/nota/buat', $data);
        $response = json_decode($response);
        if ($status === 500) {
            Flasher::setFlash($response->message, '', 'danger');
            header('Location: javascript://history.go(-1)');
            exit;
        }
        $success = 0;
        if ($status === 422) {
            foreach ($response->data as $produk) {
                $row = $this->model('Produk_model')->updateStok($produk->kode_produk, $produk->stok);
                if ($row > 0) {
                    $success += 1;
                }
            }
            Flasher::setFlash($response->message, '', 'danger');
            header('Location: javascript://history.go(-1)');
            exit;
        }
        if ($status === 201) {
            $keranjangItemSukses = $this->model('Keranjang_model')->orderItemKeranjang($idorder);
            $data = [
                'id_ekspedisi' => $_POST['id_kurir'],
                'biayaongkir' => $ongkir[$_POST['id_kurir']],
                'kodebank' => $_POST['bank'],
                'idorderprodusen' => $response->data->no_nota
            ];
            $orderSukses = $this->model('Order_model')->placeOrder($idorder, $data);
            foreach ($response->data->produk_detail as $produk) {
                $row = $this->model('Produk_model')->updateStok($produk->kode_produk, $produk->sisa_stok);
                if ($row > 0) {
                    $success += 1;
                }
            }
            if ($orderSukses > 0) {
                Flasher::setFlash('Berhasil memesan produk, silahkan melakukan pembayaran', '', 'success');
                header('Location: ' . BASEURL . '/produk');
                exit;
            }
        }
    }
    private function cleanKeys(&$array)
    {
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
    private function groupBarang($produk)
    {
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
    private function groupOrder($orders)
    {
        foreach ($orders as $order) {
            $idorder = $order['idorder'];
            if (!isset($dataGrouped[$idorder])) {
                $dataGrouped[$idorder]['idorder'] = $order['idorder'];
                $dataGrouped[$idorder]['idpelanggan'] = $order['idpelanggan'];
                $dataGrouped[$idorder]['namacustomer'] = $order['namacustomer'];
                $dataGrouped[$idorder]['tglorder'] = $order['tglorder'];
                $dataGrouped[$idorder]['total'] = $order['total'];
                $dataGrouped[$idorder]['totalprodusen'] = $order['totalprodusen'];
                $dataGrouped[$idorder]['grandtotal'] = $order['grandtotal'];
                $dataGrouped[$idorder]['grandtotalprodusen'] = $order['grandtotalprodusen'];
                $dataGrouped[$idorder]['namapenerima'] = $order['namapenerima'];
                $dataGrouped[$idorder]['alamat'] = $order['alamat'];
                $dataGrouped[$idorder]['notlp'] = $order['notlp'];
                $dataGrouped[$idorder]['idekspedisi'] = $order['idekspedisi'];
                $dataGrouped[$idorder]['biayaongkir'] = $order['biayaongkir'];
                $dataGrouped[$idorder]['biayaongkirprodusen'] = $order['biayaongkirprodusen'];
                $dataGrouped[$idorder]['noresi'] = $order['noresi'];
            }
            $dataGrouped[$idorder]['items'][] = [
                'kodebarang' => $order['kodebarang'],
                'jumlah' => $order['jumlah'],
                'diskon' => $order['diskon'],
                'diskonprodusen' => $order['diskonprodusen'],
                'harga' => $order['harga'],
                'hargaprodusen' => $order['hargaprodusen'],
                'subtotal' => $order['subtotal'],
                'subtotalprodusen' => $order['subtotalprodusen'],
                'keterangan' => $order['keterangan'],
                'kodewarna' => $order['kodewarna'],
                'kodesize' => $order['kodesize'],
                'idkelompok' => $order['idkelompok'],
                'idunit' => $order['idunit'],
                'stok' => $order['stok'],
                'jenis' => $order['jenis'],
                'imglink' => $order['imglink'],
                'berat' => $order['berat']
            ];
        }
        return array_values($dataGrouped)[0];
    }
}

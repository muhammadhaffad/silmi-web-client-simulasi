<?php
class Dashboard extends Controller {
    public function index() {
        $this->view('dashboard/templates/header');
        $this->view('dashboard/home/index');
        $this->view('dashboard/templates/footer');
    }
    public function order($idorder) {
        $orders = $this->groupOrder($this->model('Order_model')->getOrderPelanggan(), 1);
        $data['order'] = $orders;
        $this->view('dashboard/templates/header');
        $this->view('dashboard/order/index', $data);
        $this->view('dashboard/templates/footer');
    }
    private function groupOrder($orders) {
        foreach ($orders as $order) {
            $idorder = $order['idorder'];
            if(!isset($dataGrouped[$idorder])) {
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
        return array_values($dataGrouped);
    }
}
?>
<?php
class Handler extends Controller {
    public function index() {
        $requests = Helper::getJsonRequests(true);
        $updateOrder = [
            'totalprodusen' => $requests['total'],
            'grandtotalprodusen' => (int)$requests['grand_total'],
            'biayaongkirprodusen' => (int)$requests['biaya_kirim'] + (int)$requests['biaya_penanganan'],
            'noresi' => $requests['no_resi'],
        ];
        $order = $this->model('Order_model')->updateOrder($requests['no_nota'], $updateOrder);
        foreach ($requests['produk_detail'] as $produk) {
            $updateOrderDetail = [
                'diskonprodusen' => 
            ]
            $row = $this->model('Order_model')->updateOrderDetail($order['idorder'], $requests['kodebarang'], )
        }
        http_response_code(200);
    }
}
<?php
class Order_model {
    private $view = 'v_orderpelanggan';
    private $table = 'tr_order';
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function createOrder($data) {
        $idpelanggan = $_SESSION['idpelanggan'];
        $query = "INSERT INTO ".$this->table." (tglorder, idpelanggan, namapelanggan, alamat, notlp) VALUES (current_timestamp, :idpelanggan, :namapelanggan, :alamat, :notlp) RETURNING idorder";
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idpelanggan);
        $this->db->bind('namapelanggan', $data['nama_pelanggan']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('notlp', $data['no_tlp']);
        return $this->db->single();
    }
    public function getOrderPelanggan($idorder = null, $isselesai = 1) {
        $idpelanggan = $_SESSION['idpelanggan'];
        if ($idorder !== null) {
            $query = "SELECT * FROM " . $this->view . " WHERE idpelanggan=:idpelanggan AND idorder=:idorder AND isselesai=:isselesai";
            $this->db->query($query);
            $this->db->bind('idpelanggan', $idpelanggan);
            $this->db->bind('idorder', $idorder);
            $this->db->bind('isselesai', $isselesai);
        } else {
            $query = "SELECT * FROM " . $this->view . " WHERE idpelanggan=:idpelanggan AND isselesai=:isselesai";
            $this->db->query($query);
            $this->db->bind('idpelanggan', $idpelanggan);
            $this->db->bind('isselesai', $isselesai);
        }
        return $this->db->resultSet();
    }
    public function placeOrder($idorder, $data) {
        $idPelanggan = $_SESSION['idpelanggan'];
        $query = "UPDATE tr_order SET idorderprodusen=:idorderprodusen, idekspedisi=:idekspedisi, biayaongkir=:biayaongkir, kodebank=:kodebank, grandtotal=total+:biayaongkir, isselesai=1 WHERE idorder=:idorder AND idpelanggan=:idpelanggan";
        $this->db->query($query);
        $this->db->bind('idekspedisi', $data['id_ekspedisi']);
        $this->db->bind('biayaongkir', $data['biayaongkir']);
        $this->db->bind('kodebank', $data['kodebank']);
        $this->db->bind('idorderprodusen', $data['idorderprodusen']);
        $this->db->bind('idpelanggan', $idPelanggan);
        $this->db->bind('idorder', $idorder);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function updateOrder($idorderprodusen, $data) {
        $query = "UPDATE ".$this->table." SET totalprodusen=:totalprodusen, grandtotalprodusen=:grandtotalprodusen, biayaongkirprodusen=:biayaongkirprodusen, noresi=:noresi WHERE idorderprodusen=:idorderprodusen RETURNING idorder";
        $this->db->query($query);
        $this->db->bind('totalprodusen', $data['totalprodusen']);
        $this->db->bind('grandtotalprodusen', $data['grandtotalprodusen']);
        $this->db->bind('biayaongkirprodusen', $data['biayaongkirprodusen']);
        $this->db->bind('noresi', $data['noresi']);
        $this->db->bind('idorderprodusen', (int)$idorderprodusen);
        $this->db->single();
    }
    public function updateOrderDetail($idorder, $kodebarang, $data) {
        $query = "UPDATE tr_orderdetail SET diskonprodusen=:diskonprodusen, hargaprodusen=:hargaprodusen, totalprodusen=:totalprodusen WHERE idorder=:idorder AND kodebarang=:kodebarang";
        $this->db->query($query);
        $this->db->bind('diskonprodusen', $data['diskonprodusen']);
        $this->db->bind('hargaprodusen', $data['hargaprodusen']);
        $this->db->bind('totalprodusen', $data['totalprodusen']);
        $this->db->bind('kodebarang', $kodebarang);
        $this->db->bind('idorder', $idorder);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
?>
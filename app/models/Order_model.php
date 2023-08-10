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
        $query = "UPDATE tr_order SET idekspedisi=:idekspedisi, biayaongkir=:biayaongkir, kodebank=:kodebank, grandtotal=total+:biayaongkir, isselesai=1 WHERE idorder=:idorder AND idpelanggan=:idpelanggan";
        $this->db->query($query);
        $this->db->bind('idekspedisi', $data['id_ekspedisi']);
        $this->db->bind('biayaongkir', $data['biayaongkir']);
        $this->db->bind('kodebank', $data['kodebank']);
        $this->db->bind('idpelanggan', $idPelanggan);
        $this->db->bind('idorder', $idorder);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
?>
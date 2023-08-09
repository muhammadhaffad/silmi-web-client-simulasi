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
    public function getOrderPelanggan($idorder = null) {
        $idpelanggan = $_SESSION['idpelanggan'];
        if ($idorder !== null) {
            $query = "SELECT * FROM " . $this->view . " WHERE idpelanggan=:idpelanggan AND idorder=:idorder";
            $this->db->query($query);
            $this->db->bind('idpelanggan', $idpelanggan);
            $this->db->bind('idorder', $idorder);
        } else {
            $query = "SELECT * FROM " . $this->view . " WHERE idpelanggan=:idpelanggan";
            $this->db->query($query);
            $this->db->bind('idpelanggan', $idpelanggan);
        }
        return $this->db->resultSet();
    }
}
?>
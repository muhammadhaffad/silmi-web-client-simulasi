<?php
class Produk_model {
    private $view = 'v_barangpelanggan';
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getSemuaBarang() {
        $idpelanggan = $_SESSION['idpelanggan'];
        $this->db->query("SELECT * FROM ".$this->view." WHERE idpelanggan=:idpelanggan");
        $this->db->bind('idpelanggan', $idpelanggan);
        return $this->db->resultSet();
    }
    public function getBarang($idmodelbarang, $ukuran=null, $warna=null) {
        $idpelanggan = $_SESSION['idpelanggan'];
        $query = "SELECT * FROM ".$this->view." WHERE idpelanggan=:idpelanggan AND stokbarangitem > 0 AND idmodelbarang=:idmodelbarang";
        if ($ukuran !== null) {
            $query .= " AND kodesize=:kodesize";
        }
        if ($warna !== null) {
            $query .= " AND kodewarna=:kodewarna";
        }
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idpelanggan);
        $this->db->bind('idmodelbarang', $idmodelbarang);
        if ($ukuran !== null) {
            $this->db->bind("kodesize", $ukuran);
        }
        if ($warna !== null) {
            $this->db->bind("kodewarna", $warna);
        }
        return $this->db->resultSet();
    }
    public function getBarangItem($idmodelbarang, $idmodelbarangitem) {
        $idpelanggan = $_SESSION['idpelanggan'];
        $query = "SELECT * FROM ".$this->view." WHERE idpelanggan=:idpelanggan AND stokbarangitem > 0 AND idmodelbarang=:idmodelbarang AND idmodelbarangitem=:idmodelbarangitem";
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idpelanggan);
        $this->db->bind('idmodelbarang', $idmodelbarang);
        $this->db->bind('idmodelbarangitem', $idmodelbarangitem);
        return $this->db->resultSet();
    }
}
<?php
class Keranjang_model {
    private $view = 'v_keranjangpelanggan';
    private $table = 'ms_keranjang';
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function insertKeranjang($data){
        $idPelanggan = $_SESSION['idpelanggan'];
        $query = 'INSERT INTO ' . $this->table . ' (idpelanggan, jumlah, idmodelbarangitem) VALUES (:idpelanggan, :jumlah, :idmodelbarangitem)';
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idPelanggan);
        $this->db->bind('jumlah', $data['jumlah']);
        $this->db->bind('idmodelbarangitem', $data['idmodelbarangitem']);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function getKeranjangPelanggan() {
        $idPelanggan = $_SESSION['idpelanggan'];
        $query = "SELECT * FROM ". $this->view ." WHERE idpelanggan=:idpelanggan ORDER BY idkeranjang";
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idPelanggan);
        $this->db->execute();
        return $this->db->resultSet();
    }
    public function tambahJumlah($idkeranjang) {
        $idPelanggan = $_SESSION['idpelanggan'];
        $query = "UPDATE ".$this->table." SET jumlah=jumlah+1 WHERE idpelanggan=:idpelanggan AND idkeranjang=:idkeranjang";
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idPelanggan);
        $this->db->bind('idkeranjang', $idkeranjang);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function kurangJumlah($idkeranjang) {
        $idPelanggan = $_SESSION['idpelanggan'];
        $query = "UPDATE ".$this->table." SET jumlah=jumlah-1 WHERE idpelanggan=:idpelanggan AND idkeranjang=:idkeranjang";
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idPelanggan);
        $this->db->bind('idkeranjang', $idkeranjang);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function deleteItemKeranjang($idkeranjang)
    {
        $idPelanggan = $_SESSION['idpelanggan'];
        $query = "DELETE FROM ".$this->table." WHERE idpelanggan=:idpelanggan AND idkeranjang=:idkeranjang";
        $this->db->query($query);
        $this->db->bind('idpelanggan', $idPelanggan);
        $this->db->bind('idkeranjang', $idkeranjang);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
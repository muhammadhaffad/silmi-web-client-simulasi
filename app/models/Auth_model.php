<?php
class Auth_model {
    private $table = 'sc_pelanggan';
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function auth($data)
    {
        $query = "select * from sc_pelanggan where password = :password limit 1";
        $this->db->query($query);
        $this->db->bind('password', $data['password']);
        return $this->db->single();
    }
}
?>
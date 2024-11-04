<?php

class TaikhoanModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }
    public function getUserByUsername($username)
    {
        $query = 'SELECT * FROM TAIKHOAN WHERE TenTK = :username';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
  
    

}
?>
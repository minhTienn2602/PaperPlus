<?php
class ConferenceModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect(); // Lưu trữ kết nối PDO trong thuộc tính $db
    }

    public function getConferenceById($conference_id) {
        $sql = "SELECT * FROM CONFERENCES WHERE conference_id = :conference_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['conference_id' => $conference_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllConferences() {
        $sql = "SELECT * FROM CONFERENCES";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
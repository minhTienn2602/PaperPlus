<?php
class TopicModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect(); // Lưu trữ kết nối PDO trong thuộc tính $db
    }

    // Lấy tất cả các chủ đề
    public function getAllTopics() {
        $sql = "SELECT * FROM TOPICS";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chủ đề theo ID
    public function getTopicById($topic_id) {
        $sql = "SELECT * FROM TOPICS WHERE topic_id = :topic_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['topic_id' => $topic_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
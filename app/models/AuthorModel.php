<?php
class AuthorModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAuthorById($user_id) {
        $sql = "SELECT * FROM AUTHORS WHERE user_id = :user_id";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateAuthor($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $fields = implode(', ', $fields);
        $sql = "UPDATE AUTHORS SET $fields WHERE user_id = :user_id";
        $stmt = $this->db->connect()->prepare($sql);
        $data['user_id'] = $id;
        return $stmt->execute($data);
    }
    public function getAllAuthors() {
        $sql = "SELECT * FROM AUTHORS";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>